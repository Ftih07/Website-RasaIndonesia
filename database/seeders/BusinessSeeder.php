<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;
use Illuminate\Support\Facades\Storage;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        $filePath = public_path('mapsscraper.json');

        if (!file_exists($filePath)) {
            $this->command->error("File mapsscraper.json not found in storage!");
            return;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
        
        foreach ($data as $row) {
            Business::create([
                'type_id' => 1,
                'name' => $row['Place_name'],
                'address' => $row['Address1'],
                'location' => $row['Location'],
                'latitude' => $row['Latitude'] ?? null,
                'longitude' => $row['Longitude'] ?? null,
                'description' => null,
                'logo' => null,
                'open_hours' => null,
                'services' => null,
                'menu' => null,
                'media_social' => null,
                'iframe_url' => null,
                'contact' => null,
            ]);
        }
    }
}
