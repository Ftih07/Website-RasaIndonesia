<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\Business;

class ImportBusinessSeeder extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string $view = 'filament.pages.import-business-seeder';
    protected static ?string $navigationLabel = 'Import Business JSON';
    protected static ?string $title = 'Import Business Data';

    public $json_file;

    public function importData()
    {
        if (!$this->json_file) {
            session()->flash('message', 'Please upload a JSON file first.');
            return;
        }

        // Simpan file JSON ke storage
        $filePath = $this->json_file->store('json-uploads');

        // Baca file JSON
        $jsonData = Storage::get($filePath);
        $data = json_decode($jsonData, true);

        if (!is_array($data)) {
            session()->flash('message', 'Invalid JSON format.');
            return;
        }

        // Import data ke database
        foreach ($data as $row) {
            Business::create([
                'type_id' => 1,
                'name' => $row['Place_name'] ?? 'Unknown',
                'address' => $row['Address1'] ?? null,
                'location' => $row['Location'] ?? null,
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

        session()->flash('message', 'Data imported successfully!');
    }
}
