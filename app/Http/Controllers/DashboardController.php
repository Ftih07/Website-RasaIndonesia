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
        $currentMonthRevenue = Order::where('business_id', $business->id)
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->sum('total_price');

        $lastMonthRevenue = Order::where('business_id', $business->id)
            ->whereMonth('order_date', now()->subMonth()->month)
            ->whereYear('order_date', now()->subMonth()->year)
            ->sum('total_price');

        $revenueGrowth = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // === Products Sold ===
        $currentMonthProducts = OrderItem::whereHas('order', function ($q) use ($business) {
            $q->where('business_id', $business->id)
                ->whereMonth('order_date', now()->month)
                ->whereYear('order_date', now()->year);
        })
            ->sum('quantity');

        $lastMonthProducts = OrderItem::whereHas('order', function ($q) use ($business) {
            $q->where('business_id', $business->id)
                ->whereMonth('order_date', now()->subMonth()->month)
                ->whereYear('order_date', now()->subMonth()->year);
        })
            ->sum('quantity');

        $productsGrowth = $lastMonthProducts > 0
            ? (($currentMonthProducts - $lastMonthProducts) / $lastMonthProducts) * 100
            : 0;

        // === Total Orders ===
        $currentMonthOrders = Order::where('business_id', $business->id)
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->count();

        $lastMonthOrders = Order::where('business_id', $business->id)
            ->whereMonth('order_date', now()->subMonth()->month)
            ->whereYear('order_date', now()->subMonth()->year)
            ->count();

        $ordersGrowth = $lastMonthOrders > 0
            ? (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100
            : 0;

        // ambil tahun dari request (default: tahun sekarang)
        $year = $request->input('year', now()->year);

        // === Monthly Revenue ===
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(order_date) as month'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('business_id', $business->id)
            ->whereYear('order_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // === Monthly Orders ===
        $monthlyOrders = Order::select(
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
                $q->where('business_id', $business->id)
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
}
