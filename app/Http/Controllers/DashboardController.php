<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Business;
use App\Models\Type;
use App\Models\FoodCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\QrLink;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RevenueExport;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $business = $user->business;

        if (!$business) {
            return redirect()->route('home')->with('error', 'You don\'t have a business yet.');
        }

        // === Revenue ===
        $currentMonthRevenue = Order::valid()
            ->where('business_id', $business->id)
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->sum(DB::raw('total_price - order_fee'));

        $lastMonthRevenue = Order::valid()
            ->where('business_id', $business->id)
            ->whereMonth('order_date', now()->subMonth()->month)
            ->whereYear('order_date', now()->subMonth()->year)
            ->sum(DB::raw('total_price - order_fee'));

        $revenueGrowth = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // === Products Sold ===
        $currentMonthProducts = OrderItem::whereHas('order', function ($q) use ($business) {
            $q->valid() // pakai scope
                ->where('business_id', $business->id)
                ->whereMonth('order_date', now()->month)
                ->whereYear('order_date', now()->year);
        })->sum('quantity');

        $lastMonthProducts = OrderItem::whereHas('order', function ($q) use ($business) {
            $q->valid()
                ->where('business_id', $business->id)
                ->whereMonth('order_date', now()->subMonth()->month)
                ->whereYear('order_date', now()->subMonth()->year);
        })->sum('quantity');

        $productsGrowth = $lastMonthProducts > 0
            ? (($currentMonthProducts - $lastMonthProducts) / $lastMonthProducts) * 100
            : 0;

        // === Total Orders ===
        $currentMonthOrders = Order::valid()
            ->where('business_id', $business->id)
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->count();

        $lastMonthOrders = Order::valid()
            ->where('business_id', $business->id)
            ->whereMonth('order_date', now()->subMonth()->month)
            ->whereYear('order_date', now()->subMonth()->year)
            ->count();

        $ordersGrowth = $lastMonthOrders > 0
            ? (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100
            : 0;

        // ambil tahun dari request (default: tahun sekarang)
        $year = $request->input('year', now()->year);

        // === Monthly Revenue ===
        $monthlyRevenue = Order::valid()
            ->select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('SUM(total_price - order_fee) as total')
            )
            ->where('business_id', $business->id)
            ->whereYear('order_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // === Monthly Orders ===
        $monthlyOrders = Order::valid()
            ->select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('COUNT(id) as total')
            )
            ->where('business_id', $business->id)
            ->whereYear('order_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // bikin array full 12 bulan
        $monthLabels = [];
        $revenueData = [];
        $ordersData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthLabels[] = Carbon::create()->month($m)->format('M');
            $revenueData[] = $monthlyRevenue[$m] ?? 0;
            $ordersData[] = $monthlyOrders[$m] ?? 0;
        }

        // buat dropdown years (3 tahun terakhir misalnya)
        $years = range(now()->year, now()->year - 2);

        // === Best Selling Products (top 5 bulan ini) ===
        $bestSellers = OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold'),
            DB::raw('SUM(total_price) as revenue')
        )
            ->whereHas('order', function ($q) use ($business) {
                $q->valid()
                    ->where('business_id', $business->id)
                    ->whereMonth('order_date', now()->month)
                    ->whereYear('order_date', now()->year);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product') // pastiin ada relasi ke Product
            ->limit(5)
            ->get();

        // === Latest Activity Seller ===
        $activities = Activity::where('business_id', $business->id)
            ->latest()
            ->take(10)
            ->get();

        // === Avg Rating ===
        $currentMonthRating = Testimonial::where('business_id', $business->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->avg('rating');

        $lastMonthRating = Testimonial::where('business_id', $business->id)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->avg('rating');

        $ratingGrowth = $lastMonthRating > 0
            ? (($currentMonthRating - $lastMonthRating) / $lastMonthRating) * 100
            : 0;

        return view('dashboard.index', compact(
            'business',
            'currentMonthRevenue',
            'revenueGrowth',
            'currentMonthProducts',
            'productsGrowth',
            'currentMonthOrders',
            'ordersGrowth',
            'bestSellers',
            'year',
            'years',
            'monthLabels',
            'revenueData',
            'ordersData',
            'activities',
            'currentMonthRating',
            'ratingGrowth'
        ));
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $business = $user->business;

        if (!$business) {
            return redirect()->route('home')->with('error', "You don't have a business yet.");
        }

        // Ambil filter: bisa kirim ?from=YYYY-MM-DD&until=YYYY-MM-DD (opsional)
        $year  = (int) $request->input('year', now()->year);
        $from  = $request->input('from');
        $until = $request->input('until');

        // Fallback: kalau from/until kosong, pakai full year
        if (!$from || !$until) {
            $from  = Carbon::create($year, 1, 1)->toDateString();
            $until = Carbon::create($year, 12, 31)->toDateString();
        }

        $filename = "revenue-report_{$from}_to_{$until}.xlsx";

        // Kirim 3 argumen + (opsional) businessName buat header
        return Excel::download(
            new RevenueExport($business->id, $from, $until, $business->name ?? null),
            $filename
        );
    }
}
