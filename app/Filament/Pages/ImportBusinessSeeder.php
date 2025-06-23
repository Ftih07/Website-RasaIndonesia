<?php

namespace App\Filament\Pages; // Defines the namespace for this Filament custom page.

use Filament\Pages\Page; // Imports the base Filament Page class.
use Illuminate\Support\Facades\Storage; // Imports the Storage facade for file system operations.
use Livewire\WithFileUploads; // Imports Livewire trait for handling file uploads.
use App\Models\Business; // Imports the Business Eloquent model.
use App\Models\Type; // Imports the Type Eloquent model.

/**
 * Class ImportBusinessSeeder
 *
 * This Filament Page provides an administrative interface for importing business data
 * from a JSON file. It allows users to upload a JSON file containing business information
 * and associate it with a specific business type before saving it to the database.
 * This is particularly useful for bulk importing data, potentially from a web scraper.
 */
class ImportBusinessSeeder extends Page
{
    // Specifies the navigation group under which this resource will be listed in the Filament sidebar.
    protected static ?string $navigationGroup = 'Data Import Tools';

    // Sets the sorting order for this resource within its navigation group (lower numbers appear higher).
    protected static ?int $navigationSort = 1;

    // Livewire trait to enable file upload capabilities for this component.
    // This allows Livewire to handle temporary storage and processing of uploaded files.
    use WithFileUploads;

    // Sets the navigation icon for this page in the Filament admin sidebar.
    // The icon 'heroicon-o-rectangle-stack' is a generic icon from Heroicons.
    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-down';

    // Defines the Blade view file that will be rendered for this page.
    // This view typically contains the UI for file upload and type selection.
    protected static string $view = 'filament.pages.import-business-seeder';

    // Sets the label displayed for this page in the Filament navigation sidebar.
    protected static ?string $navigationLabel = 'Import Business Seeder';

    // Sets the main title displayed at the top of the page.
    protected static ?string $title = 'Import Business Data Scraper';

    /**
     * Public property to temporarily store the uploaded JSON file.
     * Livewire automatically handles binding the uploaded file to this property.
     *
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $json_file;

    /**
     * Public property to store the ID of the selected business type.
     * This ID will be assigned to all businesses imported from the JSON file.
     *
     * @var int|null
     */
    public $selectedTypeId;

    /**
     * The `mount` method is a Livewire lifecycle hook that is called once
     * when the component is initialized.
     *
     * It's used here to set the initial state of component properties.
     *
     * @return void
     */
    public function mount(): void
    {
        // Initialize `selectedTypeId` to null, ensuring no business type is pre-selected.
        $this->selectedTypeId = null;
    }

    /**
     * Handles the logic for importing business data from the uploaded JSON file.
     *
     * This method performs validation, reads the JSON, processes the data,
     * and creates new `Business` records in the database.
     *
     * @return void
     */
    public function importData(): void
    {
        // --- Validation ---
        // Check if a JSON file has been uploaded. If not, flash an error message to the session.
        if (!$this->json_file) {
            session()->flash('message', 'Please upload a JSON file first.');
            return;
        }

        // Check if a business type has been selected from the dropdown. If not, flash an error.
        if (!$this->selectedTypeId) {
            session()->flash('message', 'Please select a business type.');
            return;
        }

        // --- File Handling ---
        // Store the uploaded JSON file in the 'json-uploads' directory within your default storage disk (e.g., storage/app/json-uploads).
        // The `store()` method returns the path where the file was saved.
        $filePath = $this->json_file->store('json-uploads');

        // Read the entire contents of the uploaded JSON file from storage.
        $jsonData = Storage::get($filePath);
        // Decode the JSON string into a PHP associative array. `true` ensures it's an associative array.
        $data = json_decode($jsonData, true);

        // --- JSON Data Validation ---
        // Validate if the decoded data is a valid array. If not, it means the JSON format was incorrect.
        if (!is_array($data)) {
            session()->flash('message', 'Invalid JSON format. The JSON should be an array of objects.');
            return;
        }

        // --- Data Import Loop ---
        // Loop through each item (row) in the decoded JSON data array.
        foreach ($data as $row) {
            // Create a new `Business` record in the database using mass assignment.
            // Attributes are mapped from the JSON data, with fallback default values (e.g., 'Unknown')
            // or `null` for fields not present in the JSON or not yet utilized.
            Business::create([
                'type_id' => $this->selectedTypeId,             // Assigns the selected business type ID.
                'name' => $row['Place_name'] ?? 'Unknown',      // Uses 'Place_name' from JSON, defaults to 'Unknown'.
                'address' => $row['Address1'] ?? null,          // Uses 'Address1' from JSON.
                'location' => $row['Location'] ?? null,         // Uses 'Location' from JSON.
                'latitude' => $row['Latitude'] ?? null,         // Uses 'Latitude' from JSON.
                'longitude' => $row['Longitude'] ?? null,       // Uses 'Longitude' from JSON.
                'description' => null,                          // Placeholder, assumed not in JSON or handled later.
                'logo' => null,                                 // Placeholder.
                'open_hours' => null,                           // Placeholder.
                'services' => null,                             // Placeholder.
                'menu' => null,                                 // Placeholder.
                'media_social' => null,                         // Placeholder.
                'iframe_url' => null,                           // Placeholder.
                'contact' => null,                              // Placeholder.
                // Note: Other fields from the `Business` model's `$fillable` array
                // (e.g., 'slug', 'country', 'city', 'unique_code', 'document', 'order', 'reserve')
                // are not explicitly mapped here. They would either be set to default values by the database
                // or their model's `booted()` method (like `slug`), or remain null if not provided.
            ]);
        }

        // --- Success Message ---
        // Flash a success message to the session after all data has been successfully imported.
        session()->flash('message', 'Data imported successfully!');
    }

    /**
     * Livewire computed property to retrieve all available business types.
     *
     * This method is automatically called when `$this->types` is accessed in the Blade view,
     * allowing the dynamic population of a dropdown (e.g., a <select> element).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTypesProperty(): \Illuminate\Database\Eloquent\Collection
    {
        // Retrieve all records from the 'types' table.
        return Type::all();
    }
}
