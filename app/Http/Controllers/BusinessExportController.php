<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Business;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

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

    public function exportWordZip()
    {
        // ambil semua business
        $businesses = \App\Models\Business::with('type')->get();

        // folder sementara di storage/app/exports
        $exportPath = storage_path('app/exports');
        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $zipFileName = 'businesses_export_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath = $exportPath . '/' . $zipFileName;

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not create ZIP file');
        }

        foreach ($businesses as $business) {
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();

            $section->addText("Business Export Report", ['bold' => true, 'size' => 16]);
            $section->addTextBreak(1);

            $section->addText("ID: {$business->id}", ['bold' => true]);
            $section->addText("Name: {$business->name}");
            $section->addText("Type: " . ($business->type->title ?? '-'));
            $section->addText("Country: {$business->country}");
            $section->addText("City: {$business->city}");
            $section->addText("Address: {$business->address}");
            $section->addText("Location: {$business->location}");
            $section->addText("Latitude: {$business->latitude}");
            $section->addText("Longitude: {$business->longitude}");
            $section->addText("Description: {$business->description}");
            $section->addText("Updated At: {$business->updated_at}");

            // simpan sementara file docx
            $docxName = 'business_' . $business->id . '.docx';
            $tempDocxPath = $exportPath . '/' . $docxName;

            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($tempDocxPath);

            // tambahkan ke zip
            $zip->addFile($tempDocxPath, $docxName);
        }

        $zip->close();

        // download zip & hapus setelah dikirim
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $businesses = \App\Models\Business::with('type')->get();

        $pdf = Pdf::loadView('exports.businesses-pdfword', compact('businesses'))
            ->setPaper('a4', 'portrait');

        $fileName = 'businesses_export_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($fileName);
    }
}
