<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sticker;
use Illuminate\Support\Facades\Storage;

class StickerController extends Controller
{
    public function generate(Sticker $sticker)
    {
        $business = $sticker->business; // Ambil bisnis terkait

        $pdf = Pdf::loadView('sticker-template', [
            'businessName' => $business->name,
            'uniqueCode' => $sticker->unique_code,
        ]);

        $filePath = 'stickers/' . uniqid() . '.pdf';

        Storage::disk('public')->put($filePath, $pdf->output());

        if (!Storage::disk('public')->exists($filePath)) {
            dd("File gagal dibuat!");
        }

        // Update record stiker
        $sticker->update(['pdf_path' => $filePath]);

        // ✅ Update tabel `businesses` dengan unique_code & PDF path
        $business->update([
            'unique_code' => $sticker->unique_code,
            'document' => $filePath, // Sesuai dengan field PDF
        ]);

        return redirect()->back()->with('success', 'Sticker generated successfully!');
    }
}
