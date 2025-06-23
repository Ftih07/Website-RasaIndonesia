<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use App\Models\Business;
use Illuminate\Support\Facades\Storage;

class ImportTestimonialSeeder extends Page
{
    // Specifies the navigation group under which this resource will be listed in the Filament sidebar.
    protected static ?string $navigationGroup = 'Data Import Tools';

    // Sets the sorting order for this resource within its navigation group (lower numbers appear higher).
    protected static ?int $navigationSort = 1;

    use WithFileUploads; // Enables file upload functionality

    // Navigation icon for Filament panel
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';

    // Defines the Blade view associated with this page
    protected static string $view = 'filament.pages.import-testimonial-seeder';

    // Navigation label in the sidebar
    protected static ?string $navigationLabel = 'Import Testimonials Seeder';

    // Page title
    protected static ?string $title = 'Import Testimonial Data Scraper';

    public $json_file; // Variable to store uploaded JSON file
    public $business_id; // Variable to store selected business ID

    /**
     * Handles the process of importing testimonial data from a JSON file.
     */
    public function importData()
    {
        // Check if both a file and a business ID are provided
        if (!$this->json_file || !$this->business_id) {
            session()->flash('message', 'Please select a business and upload a JSON file first.');
            return;
        }

        // Store the uploaded JSON file in `storage/app/json-uploads`
        $filePath = $this->json_file->store('json-uploads');

        // Ensure the file was successfully saved
        if (!$filePath || !Storage::exists($filePath)) {
            session()->flash('message', 'Failed to save file.');
            return;
        }

        // Read the stored JSON file
        $jsonData = Storage::get($filePath);
        $data = json_decode($jsonData, true);

        // Validate JSON format
        if (!is_array($data)) {
            session()->flash('message', 'Invalid JSON format.');
            return;
        }

        // Loop through each row and insert data into the `testimonials` table
        foreach ($data as $row) {
            Testimonial::create([
                'business_id' => $this->business_id, // Associate with selected business
                'testimonial_user_id' => null, // No user ID provided
                'name' => $row['name'], // Author name
                'description' => $row['text'] ?? 'No review text', // Review text with fallback
                'rating' => $row['stars'] ?? 0, // Rating with default value
                'image_url' => $row['reviewerPhotoUrl'] ?? null, // Image URL Users
                'publishedAtDate' => $row['publishedAtDate'] ?? null, // publishedAtDate Value
            ]);
        }

        // Flash success message
        session()->flash('message', 'Testimonials imported successfully!');
    }

    /**
     * Fetches available businesses and returns them as an array of options.
     *
     * return array Associative array of business names mapped to their IDs.
     */
    protected function getBusinessOptions(): array
    {
        return Business::pluck('name', 'id')->toArray();
    }
}
