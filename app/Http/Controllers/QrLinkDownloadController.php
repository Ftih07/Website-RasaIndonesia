<?php

namespace App\Http\Controllers;

use App\Models\QrLink;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QrLinkDownloadController extends Controller
{
    public function download($id)
    {
        $qr = QrLink::findOrFail($id);

        $qrImage = QrCode::format('svg')->size(300)->generate($qr->url);

        $filename = 'qr_' . str_replace([' ', '/'], '_', strtolower($qr->name)) . '.svg';

        return response($qrImage, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function generateAndSave($id)
    {
        $qr = QrLink::findOrFail($id);

        // Ubah format ke PNG
        $qrPng = \QrCode::format('png')->size(300)->generate($qr->url);

        $filename = 'qr_' . str_replace([' ', '/'], '_', strtolower($qr->name)) . '.png';

        // Simpan ke storage/app/public/qr_codes
        Storage::disk('public')->put('qr_codes/' . $filename, $qrPng);

        // Simpan path ke database kalau mau
        $qr->qr_path = 'qr_codes/' . $filename;
        $qr->save();

        return $filename;
    }
}
