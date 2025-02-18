<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\Business;
use App\Models\Type;

class ImportBusinessSeeder extends Page
{
    use WithFileUploads; // Trait from Livewire for handling file uploads.

    // Set the navigation icon in the Filament sidebar.
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Define the view used for the page.
    protected static string $view = 'filament.pages.import-business-seeder';

    // Set the navigation label displayed in the sidebar.
    protected static ?string $navigationLabel = 'Import Business JSON';

    // Set the page title.
    protected static ?string $title = 'Import Business Data Scraper';

    // Property to store the uploaded JSON file.
    public $json_file;

    // Property to store the selected business type ID.
    public $selectedTypeId;

    // Method called when the page is mounted.
    public function mount()
    {
        $this->selectedTypeId = null; // Set the initial business type ID to null.
    }

    // Function to import business data from a JSON file.
    public function importData()
    {
        // Validate if a JSON file has been uploaded.
        if (!$this->json_file) {
            session()->flash('message', 'Please upload a JSON file first.');
            return;
        }

        // Validate if a business type has been selected.
        if (!$this->selectedTypeId) {
            session()->flash('message', 'Please select a business type.');
            return;
        }

        // Save the uploaded JSON file to storage in the 'json-uploads' folder.
        $filePath = $this->json_file->store('json-uploads');

        // Read the contents of the uploaded JSON file.
        $jsonData = Storage::get($filePath);
        $data = json_decode($jsonData, true); // Convert JSON to a PHP array.

        // Validate if the JSON format is correct.
        if (!is_array($data)) {
            session()->flash('message', 'Invalid JSON format.');
            return;
        }

        // Loop through and save business data to the database.
        foreach ($data as $row) {
            Business::create([
                'type_id' => $this->selectedTypeId, // Use the selected business type.
                'name' => $row['Place_name'] ?? 'Unknown', // Use the business name or default to 'Unknown'.
                'address' => $row['Address1'] ?? null, // Store the address if available.
                'location' => $row['Location'] ?? null, // Store the location if available.
                'latitude' => $row['Latitude'] ?? null, // Store latitude coordinates if available.
                'longitude' => $row['Longitude'] ?? null, // Store longitude coordinates if available.
                'description' => null, // Additional column not yet used.
                'logo' => null, // Additional column not yet used.
                'open_hours' => null, // Additional column not yet used.
                'services' => null, // Additional column not yet used.
                'menu' => null, // Additional column not yet used.
                'media_social' => null, // Additional column not yet used.
                'iframe_url' => null, // Additional column not yet used.
                'contact' => null, // Additional column not yet used.
            ]);
        }

        // Display a success message after data is successfully imported.
        session()->flash('message', 'Data imported successfully!');
    }

    // Getter to retrieve all data from the 'types' table and display it in a dropdown.
    public function getTypesProperty()
    {
        return Type::all(); // Retrieve all business types from the database.
    }
}
