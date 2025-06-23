<?php

namespace App\Filament\Pages; // Defines the namespace for this custom Filament page.

use Filament\Pages\Page; // Imports the base class for creating custom Filament pages.
use Livewire\WithFileUploads; // Imports Livewire trait to handle file uploads.
use App\Models\Testimonial; // Imports the Testimonial Eloquent model.
use App\Models\Business; // Imports the Business Eloquent model.
use Illuminate\Support\Facades\Storage; // Imports the Storage facade for file system operations.

/**
 * Class ImportTestimonialSeeder
 *
 * This Filament Page provides an administrative interface for importing testimonial data
 * from an uploaded JSON file. It allows users to associate these testimonials with a
 * specific business in the database. This is particularly useful for populating
 * testimonial data, potentially from a web scraping source.
 */
class ImportTestimonialSeeder extends Page
{
    /**
     * The navigation group for this page in the Filament sidebar.
     * Pages within the same group will be displayed together under that group heading.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Data Import Tools';

    /**
     * The sort order for this page within its navigation group.
     * Pages with a lower number will appear higher in the sidebar.
     *
     * @var int|null
     */
    protected static ?int $navigationSort = 1;

    // Livewire trait that enables functionality for handling file uploads within this Livewire component.
    use WithFileUploads;

    /**
     * The Heroicons icon to display next to the page link in the Filament admin panel navigation.
     * 'heroicon-o-document-arrow-down' visually suggests an import or download action.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';

    /**
     * Defines the Blade view file that this Filament page will render.
     * This view (`resources/views/filament/pages/import-testimonial-seeder.blade.php`)
     * contains the HTML structure for the file upload and business selection form.
     *
     * @var string
     */
    protected static string $view = 'filament.pages.import-testimonial-seeder';

    /**
     * Readable label displayed for this page in the Filament sidebar navigation.
     *
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Import Testimonials Seeder';

    /**
     * The main title that appears at the top of the page when it's accessed in the admin panel.
     *
     * @var string|null
     */
    protected static ?string $title = 'Import Testimonial Data Scraper';

    /**
     * Public Livewire property to hold the uploaded JSON file.
     * Livewire automatically binds the uploaded file object to this property.
     *
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $json_file;

    /**
     * Public Livewire property to hold the ID of the selected Business.
     * All testimonials imported from the JSON file will be associated with this Business ID.
     *
     * @var int|null
     */
    public $business_id;

    /**
     * Handles the process of importing testimonial data from an uploaded JSON file.
     *
     * This method is triggered when the import action is performed on the page.
     * It includes validation for the uploaded file and selected business,
     * reads and decodes the JSON data, and then creates new Testimonial records.
     *
     * @return void
     */
    public function importData(): void
    {
        // --- Input Validation ---
        // Checks if both a JSON file has been uploaded AND a business ID has been selected.
        // If either is missing, a flash message is displayed, and the function returns early.
        if (!$this->json_file || !$this->business_id) {
            session()->flash('message', 'Please select a business and upload a JSON file first.');
            return;
        }

        // --- File Storage ---
        // Stores the uploaded JSON file in the 'json-uploads' directory within the default storage disk.
        // The `store()` method returns the relative path to the stored file.
        $filePath = $this->json_file->store('json-uploads');

        // Verifies that the file was successfully stored and exists in the storage.
        // If storage failed (e.g., due to permissions), an error message is flashed.
        if (!$filePath || !Storage::exists($filePath)) {
            session()->flash('message', 'Failed to save file. Please check storage permissions.');
            return;
        }

        // --- JSON Parsing ---
        // Reads the entire content of the stored JSON file.
        $jsonData = Storage::get($filePath);
        // Decodes the JSON string into a PHP associative array. `true` ensures associative array output.
        $data = json_decode($jsonData, true);

        // --- JSON Data Validation ---
        // Validates if the decoded data is indeed an array.
        // If the JSON structure is not an array of objects (which is expected for multiple testimonials),
        // an error message is flashed.
        if (!is_array($data)) {
            session()->flash('message', 'Invalid JSON format. Expected an array of testimonial objects.');
            return;
        }

        // --- Data Import Loop ---
        // Iterates through each array element (representing a single testimonial) in the decoded JSON data.
        foreach ($data as $row) {
            // Creates a new Testimonial record in the database using mass assignment.
            // Data from the JSON row is mapped to corresponding database columns.
            // Null coalescing operator (??) provides fallback default values if JSON keys are missing.
            Testimonial::create([
                'business_id' => $this->business_id,             // Associates the testimonial with the selected business.
                'testimonial_user_id' => null,                   // Placeholder: Assuming no specific user ID from scraper.
                'name' => $row['name'] ?? 'Anonymous Reviewer',  // Reviewer's name, defaults if not present.
                'description' => $row['text'] ?? 'No review text', // The testimonial text, with a fallback.
                'rating' => $row['stars'] ?? 0,                  // The rating (e.g., 1-5 stars), defaults to 0.
                'image_url' => $row['reviewerPhotoUrl'] ?? null, // URL for the reviewer's photo, if available.
                'publishedAtDate' => $row['publishedAtDate'] ?? null, // Date the testimonial was published.
            ]);
        }

        // --- Success Feedback ---
        // Flashes a success message to the session after all testimonials have been processed and imported.
        session()->flash('message', 'Testimonials imported successfully!');
    }

    /**
     * Fetches all available businesses from the database and formats them
     * into an associative array suitable for a dropdown selection (e.g., in a Filament form).
     *
     * This is a "computed property" in Livewire, meaning it's automatically re-evaluated
     * when accessed, providing fresh data without manual refresh logic in the view.
     *
     * @return array Associative array where keys are business IDs and values are business names.
     */
    protected function getBusinessOptions(): array
    {
        // Plucks the 'name' and 'id' columns from all Business records and converts them to an array.
        // The 'id' will be used as the array key, and 'name' will be the value, which is perfect for select options.
        return Business::pluck('name', 'id')->toArray();
    }
}
