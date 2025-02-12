<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryBusiness; // Ganti model ke GalleryBusiness
use Illuminate\Support\Facades\File;

class GallerySeeder extends Seeder
{
    public function run()
    {
        $filePath = public_path('business/google_images.json'); // Pastikan file ada di `public/`

        if (!file_exists($filePath)) {
            $this->command->error("File google_images.json tidak ditemukan di public!");
            return;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        foreach ($data as $row) {
            GalleryBusiness::create([
                'business_id' => 14, // Sesuaikan dengan ID bisnis yang benar
                'title' => $row['name'],
                'image' => $row['original_photo_url'], 
            ]);
        }

        $this->command->info("Seeder GalleryBusiness berhasil dijalankan!");
    }
}
