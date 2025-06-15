<?php

namespace App\Exports; // Defines the namespace for the export class.

use App\Models\Business; // Imports the Business Eloquent model.
use Maatwebsite\Excel\Concerns\FromCollection; // Trait to specify that the export gets its data from a collection.
use Maatwebsite\Excel\Concerns\WithHeadings; // Trait to add a header row to the export.
use Maatwebsite\Excel\Concerns\WithMapping; // Trait to map data from the collection to the export row.
use Maatwebsite\Excel\Concerns\WithStyles; // Trait to apply styles to the export.
use Maatwebsite\Excel\Concerns\WithTitle; // Trait to set the title of the worksheet.
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Trait to automatically size columns.
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Imports the Worksheet class for styling.
use PhpOffice\PhpSpreadsheet\Style\Fill; // Imports Fill class for background colors in styles.
use Carbon\Carbon; // Imports Carbon for date and time formatting.

/**
 * Class BusinessesExport
 *
 * This class is responsible for exporting `Business` model data into an Excel spreadsheet.
 * It implements several interfaces from the Maatwebsite/Laravel-Excel package to customize
 * the export process, including fetching data, defining headings, mapping data to rows,
 * applying styles, setting the worksheet title, and auto-sizing columns.
 */
class BusinessesExport implements
    FromCollection,   // Specifies that the export will gather data from a Laravel collection.
    WithHeadings,     // Indicates that the export will include a header row.
    WithMapping,      // Allows for custom formatting and selection of data for each row.
    WithStyles,       // Enables applying custom styles to cells/rows/columns.
    WithTitle,        // Allows setting the title of the Excel worksheet tab.
    ShouldAutoSize    // Automatically adjusts column widths based on content.
{
    /**
     * Retrieves the data collection for the export.
     *
     * This method fetches all `Business` records from the database. It eagerly loads
     * related models (`type`, `qrLink`, `galleries`, `products`) to prevent N+1 query issues,
     * ensuring that related data is available when mapping each business.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Business::with(['type', 'qrLink', 'galleries', 'products'])->get();
    }

    /**
     * Defines the column headings for the Excel export.
     *
     * These headings will appear in the first row of the exported spreadsheet,
     * providing labels for each column of data. The order here dictates the column order.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',                       // Unique identifier for the business.
            'Business Name',            // The name of the business.
            'Type',                     // The type of business (e.g., Restaurant, Shop).
            'Business Data Update On',  // Timestamp of the last update to the business record.
            'Business Unique ID',       // A unique code associated with the business.
            'Business QR Code Name',    // Name associated with the business's QR code link.
            'Food Categories',          // List of food categories if applicable.
            'Description',              // Detailed description of the business.
            'Logo',                     // Path or URL to the business's logo image.
            'Address',                  // Physical address of the business.
            'Business Country',         // Country where the business is located.
            'Business City',            // City where the business is located.
            'Iframe URL',               // URL for an embedded map or external content.
            'Open Hours',               // Business operating hours (often in JSON format).
            'Services',                 // Services offered by the business (often in JSON format).
            'Menu',                     // Link or description of the business's menu.
            'Media Social',             // Social media links for the business (often in JSON format).
            'Location',                 // General location information.
            'Contact',                  // Contact details for the business (often in JSON format).
            'Latitude',                 // Latitude coordinate of the business location.
            'Longitude',                // Longitude coordinate of the business location.
            'Document',                 // Link or description of a related document.
            'Order',                    // Information related to ordering (often in JSON format).
            'Reserve',                  // Information related to reservations (often in JSON format).
            'Galleries',                // Titles and URLs of associated gallery images.
            'Products',                 // Names and prices of associated products.
        ];
    }

    /**
     * Maps a single `Business` model instance to an array representing a row in the Excel export.
     *
     * This method specifies exactly what data from each business object will be included
     * in the spreadsheet and how it should be formatted. It also handles related data.
     *
     * @param mixed $business The Business model instance to map.
     * @return array
     */
    public function map($business): array
    {
        return [
            $business->id,
            $business->name,
            $business->type->title ?? '', // Accesses the title of the related 'type' model, defaults to empty string if not set.
            $business->updated_at
                ? 'Updated On: ' . Carbon::parse($business->updated_at)->format('D F d, Y \a\t gA')
                : '', // Formats the updated_at timestamp or returns empty if null.
            $business->unique_code,
            $business->qrLink->name ?? '', // Accesses the name of the related 'qrLink' model, defaults to empty string.
            // Joins the titles of all associated food categories into a comma-separated string.
            $business->food_categories->pluck('title')->join(', '),
            $business->description,
            $business->logo,
            $business->address,
            $business->country,
            $business->city,
            $business->iframe_url,
            json_encode($business->open_hours), // Converts the 'open_hours' attribute (assumed JSON) into a JSON string.
            json_encode($business->services),   // Converts the 'services' attribute (assumed JSON) into a JSON string.
            $business->menu,
            json_encode($business->media_social), // Converts 'media_social' (assumed JSON) into a JSON string.
            $business->location,
            json_encode($business->contact),    // Converts 'contact' (assumed JSON) into a JSON string.
            $business->latitude,
            $business->longitude,
            $business->document,
            json_encode($business->order),      // Converts 'order' (assumed JSON) into a JSON string.
            json_encode($business->reserve),    // Converts 'reserve' (assumed JSON) into a JSON string.
            // Maps through associated 'galleries', formatting each into 'Title (Storage_URL)' and joining.
            $business->galleries->map(function ($gallery) {
                return $gallery->title . ' (' . asset('storage/' . $gallery->image) . ')';
            })->join(', '),
            // Maps through associated 'products', formatting each into 'Name - Price' and joining.
            $business->products->map(function ($product) {
                return $product->name . ' - ' . $product->price;
            })->join(', '),
        ];
    }

    /**
     * Applies styling to the Excel worksheet.
     *
     * This method is used to define visual styles for cells, rows, or columns,
     * such as bolding headers or setting background colors.
     *
     * @param Worksheet $sheet The PhpOffice\PhpSpreadsheet\Worksheet\Worksheet instance.
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Style for the first row (headings).
            // Makes the font bold and sets the text color to white.
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ] + [
            // Style for the header row range (from cell A1 to Y1).
            // Sets the background fill color to a specific blue (RGB: 4F81BD).
            'A1:Y1' => ['fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD']
            ]],
        ];
    }

    /**
     * Sets the title of the Excel worksheet tab.
     *
     * This string will be displayed as the name of the sheet tab in the Excel file.
     *
     * @return string
     */
    public function title(): string
    {
        return 'Businesses Export';
    }
}