<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Business;

class BusinessExportController extends Controller
{
    //

    public function exportSinglePdf($id)
    {
        $business = Business::with(['type', 'qrLink', 'galleries', 'products'])->findOrFail($id);
        $businesses = collect([$business]);

        $pdf = Pdf::loadView('exports.businesses-pdf', compact('businesses'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("business-{$business->id}.pdf");
    }

    // Function untuk mengekspor semua bisnis
    public function exportAllPdf()
    {
        // Ambil semua data bisnis beserta relasinya
        $businesses = Business::with(['type', 'qrLink', 'galleries', 'products'])->get();

        // Gunakan DomPDF untuk generate PDF
        $pdf = Pdf::loadView('exports.businesses-pdf', [
            'businesses' => $businesses,
        ])->setPaper('a4', 'landscape');

        // Download PDF
        return $pdf->download('all-businesses.pdf');
    }
}
