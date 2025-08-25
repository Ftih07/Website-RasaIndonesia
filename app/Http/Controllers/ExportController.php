<?php

namespace App\Http\Controllers;

use App\Exports\PayoutsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportPayouts(Request $request)
    {
        $from = $request->query('from'); // format: Y-m-d
        $to   = $request->query('to');   // format: Y-m-d

        $export   = new PayoutsExport($from, $to);
        $filename = 'payouts'
            . ($from || $to ? '_' . ($from ?? 'start') . '_to_' . ($to ?? 'end') : '')
            . '.xlsx';

        return Excel::download($export, $filename);
    }

    public function exportRevenue(Request $request)
    {
        $from = $request->query('from');
        $until = $request->query('until');
        $businessId = $request->query('business_id');

        $export = new \App\Exports\RevenueReportExport($from, $until, $businessId);
        $filename = 'revenue_report'
            . ($from || $until ? "_{$from}_to_{$until}" : '')
            . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
    }

    public function exportOrders(Request $request)
    {
        $from = $request->query('from');
        $until = $request->query('until');
        $businessId = $request->query('business_id');
        $paymentStatus = $request->query('payment_status');
        $deliveryStatus = $request->query('delivery_status');

        $export = new \App\Exports\OrdersExport($from, $until, $businessId, $paymentStatus, $deliveryStatus);
        $filename = 'orders_report'
            . ($from || $until ? "_{$from}_to_{$until}" : '')
            . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
    }
}
