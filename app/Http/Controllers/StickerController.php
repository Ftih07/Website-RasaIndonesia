<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sticker;
use Illuminate\Support\Facades\Storage;

class StickerController extends Controller
{
    public function generate(Business $business)
    {
        if (!$business->unique_code) {
            $business->update(['unique_code' => strtoupper(uniqid('BIZ-'))]);
        }

        // Tentukan ukuran PDF (300x300 px setara dengan 8x8 cm)
        $customPaper = [0, 0, 350, 350]; // Satuan dalam mm

        // Generate PDF dengan ukuran yang sudah diatur
        $pdf = Pdf::loadView('sticker-template', [
            'businessName' => $business->name,
            'uniqueCode' => $business->unique_code,
        ])->setPaper($customPaper, 'portrait'); // Set ukuran kertas & orientasi

        $filePath = 'stickers/' . uniqid() . '.pdf';

        Storage::disk('public')->put($filePath, $pdf->output());

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'Failed to generate sticker.');
        }

        $business->update(['document' => $filePath]);

        return redirect()->back()->with('success', 'Sticker generated successfully!');
    }
}
