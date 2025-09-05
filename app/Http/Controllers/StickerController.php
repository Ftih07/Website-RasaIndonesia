<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class StickerController extends Controller
{
    public function generate(Business $business)
    {
        // Generate unique code jika belum ada
        if (!$business->unique_code) {
            $business->update(['unique_code' => strtoupper(uniqid('BIZ-'))]);
        }

        // Ambil data QR code dari relasi
        $qrLink = $business->qrLink;
        if (!$qrLink || !$qrLink->qr_path) {
            return redirect()->back()->with('error', 'QR Code is not yet available for this business.');
        }

        // Tentukan ukuran PDF (300x300 px setara dengan 8x8 cm)
        $customPaper = [0, 0, 350, 350]; // Satuan dalam mm

        // Generate PDF
        $pdf = Pdf::loadView('sticker-template', [
            'businessName' => $business->name,
            'uniqueCode' => $business->unique_code,
            'qrPath' => public_path('storage/qr_codes/' . basename($qrLink->qr_path)),
        ])->setPaper($customPaper, 'portrait');

        // Simpan PDF
        $filePath = 'stickers/' . uniqid() . '.pdf';
        Storage::disk('public')->put($filePath, $pdf->output());

        // Update path dokumen di database
        $business->update(['document' => $filePath]);

        return redirect()->back()->with('success', 'Sticker generated successfully!');
    }
}
