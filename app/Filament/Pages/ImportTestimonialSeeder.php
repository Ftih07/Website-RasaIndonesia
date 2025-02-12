<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use App\Models\Business;
use Illuminate\Support\Facades\Storage;

class ImportTestimonialSeeder extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.import-testimonial-seeder';
    protected static ?string $navigationLabel = 'Import Testimonials';
    protected static ?string $title = 'Import Testimonial Data';

    public $json_file;
    public $business_id;

    public function importData()
    {
        if (!$this->json_file || !$this->business_id) {
            session()->flash('message', 'Please select a business and upload a JSON file first.');
            return;
        }
    
        // Simpan file JSON ke storage
        $filePath = $this->json_file->store('json-uploads'); // Laravel akan menyimpannya ke `storage/app/json-uploads`
    
        if (!$filePath || !Storage::exists($filePath)) {
            session()->flash('message', 'Failed to save file.');
            return;
        }
    
        // Baca file JSON dari storage
        $jsonData = Storage::get($filePath);
        $data = json_decode($jsonData, true);
    
        if (!is_array($data)) {
            session()->flash('message', 'Invalid JSON format.');
            return;
        }
    
        foreach ($data as $row) {
            Testimonial::create([
                'business_id' => $this->business_id,
                'testimonial_user_id' => null,
                'name' => $row['author_title'],
                'description' => $row['review_text'] ?? 'No review text',
                'rating' => $row['rating'] ?? 0,
            ]);
        }
    
        session()->flash('message', 'Testimonials imported successfully!');
    }
    
    protected function getBusinessOptions(): array
    {
        return Business::pluck('name', 'id')->toArray();
    }
}
