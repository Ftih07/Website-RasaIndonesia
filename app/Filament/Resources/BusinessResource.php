<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers;
use App\Http\Controllers\StickerController;
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\TrashedFilter;

/**
 * BusinessResource
 *
 * This class defines the Filament administrative interface for the Business model.
 * It manages how business records are displayed, created, edited, and deleted in the admin panel.
 */
class BusinessResource extends Resource
{
    /**
     * The Eloquent model associated with this resource.
     *
     * @var string|null
     */
    protected static ?string $model = Business::class;

    /**
     * Get the navigation badge value.
     *
     * This method displays the total count of business records next to the navigation item.
     *
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        return Business::count(); // Displays the total count of business data
    }

    /**
     * The navigation group for this resource.
     * Resources within the same group will be displayed together in the navigation.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Business Operations';

    /**
     * The sort order for this resource in the navigation.
     * Lower numbers appear higher in the navigation menu.
     *
     * @var int|null
     */
    protected static ?int $navigationSort = 2;

    /**
     * The navigation icon for the resource.
     * Uses a Heroicons icon to represent the Business resource.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    /**
     * Defines the form schema for creating and editing Business records.
     *
     * @param Form $form The form instance.
     * @return Form The configured form instance.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select field for business type, linked to the 'type' relationship.
                Forms\Components\Select::make('type_id')
                    ->label('Type Business')
                    ->relationship('type', 'title') // Links to the 'title' column of the 'type' model.
                    ->required(), // This field is mandatory.

                // Text input for a unique business code.
                Forms\Components\TextInput::make('unique_code')
                    ->label('Unique Code')
                    ->nullable() // This field is optional.
                    ->placeholder('Enter unique code')
                    ->columnSpan(2), // Spans two columns in the form layout.

                // Select field for associating a QR Code link.
                Forms\Components\Select::make('qr_link_id')
                    ->label('QR Code')
                    ->relationship('qrLink', 'name') // Links to the 'name' column of the 'qrLink' model.
                    ->searchable() // Allows searching within the dropdown options.
                    ->preload() // Loads all options upfront for faster access.
                    ->placeholder('Select QR code')
                    ->columnSpan(2), // Spans two columns in the form layout.

                // Placeholder to display the associated QR code image.
                Forms\Components\Placeholder::make('qr_link_id')
                    ->content(function ($record) {
                        // Check if a record exists and has a QR link with a path.
                        if (!$record || !$record->qrLink || !$record->qrLink->qr_path) {
                            return 'No QR Assigned'; // Display message if no QR is assigned.
                        }

                        // Construct the full URL to the QR code image.
                        $url = asset('storage/' . $record->qrLink->qr_path);

                        // Return HTML to display the QR code image.
                        return new \Illuminate\Support\HtmlString(
                            '<div style="border:1px solid #ccc;padding:10px;">'
                                . '<img src="' . $url . '" style="width:100px;" />'
                                . '<br><small>' . $url . '</small></div>'
                        );
                    })
                    ->columnSpan(2) // Spans two columns.
                    ->reactive(), // Makes the placeholder reactive to changes in other fields.

                // File upload field for a business document (sticker), specifically PDF.
                Forms\Components\FileUpload::make('document')
                    ->label('Upload Sticker (PDF)')
                    ->directory('documents') // Stores uploaded files in the 'documents' directory within storage.
                    ->acceptedFileTypes(['application/pdf']) // Only accepts PDF files.
                    ->maxSize(10240), // Maximum file size of 10MB (10240 KB).

                // Multi-select field for food categories associated with the business.
                Forms\Components\Select::make('food_categories')
                    ->label('Food Categories in Business')
                    ->relationship('food_categories', 'title') // Defines a many-to-many relationship.
                    ->multiple() // Allows selecting multiple categories.
                    ->preload(), // Loads all options upfront.

                // Text input for the business name.
                Forms\Components\TextInput::make('name')
                    ->label('Business Name')
                    ->required(), // This field is mandatory.

                // Text input for the business country.
                Forms\Components\TextInput::make('country')
                    ->label('Business Country'),

                // Text input for the business city.
                Forms\Components\TextInput::make('city')
                    ->label('Business City'),

                // Textarea input for a description of the business.
                Forms\Components\Textarea::make('description')
                    ->label('Business Description'),

                // File upload input for the business logo.
                Forms\Components\FileUpload::make('logo')
                    ->label('Logo')
                    ->directory('logos'), // Stores uploaded files in the 'logos' directory.

                // Textarea input for the business address.
                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->required(), // This field is mandatory.

                // Key-value input for defining business open hours.
                Forms\Components\KeyValue::make('open_hours')
                    ->label('Open Hours')
                    ->keyLabel('Day') // Label for the key column (e.g., "Monday").
                    ->valueLabel('Hours'), // Label for the value column (e.g., "9:00 AM - 5:00 PM").

                // Checkbox list for available business services.
                Forms\Components\CheckboxList::make('services')
                    ->label('Services')
                    ->options([
                        'Dine In' => 'Dine In',
                        'Delivery' => 'Delivery',
                    ]),

                // File upload input for the business menu list.
                Forms\Components\FileUpload::make('menu')
                    ->label('Menu List')
                    ->directory('menu'), // Stores uploaded files in the 'menu' directory.

                // Repeater for managing business order links.
                Forms\Components\Repeater::make('order')
                    ->label('Business Order Link')
                    ->schema([
                        // Select field for the ordering platform.
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'Menulog' => 'Menulog',
                                'DoorDash' => 'DoorDash',
                                'UberEAST' => 'UberEAST',
                                'Abacus' => 'Abacus',
                                'Fantuan' => 'Fantuan',
                                'Website' => 'Website',
                                'HungryPanda' => 'HungryPanda',
                            ])
                            ->required(), // This field is mandatory.
                        // Text input for the order link URL.
                        Forms\Components\TextInput::make('link')
                            ->label('Link')
                            ->url(), // Validates as a URL.
                        // Text input for the name associated with the order link.
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->nullable(),
                    ])
                    ->columns(2), // Arranges sub-fields in two columns.

                // Repeater for managing business reservation links.
                Forms\Components\Repeater::make('reserve')
                    ->label('Business Reserve Link')
                    ->schema([
                        // Select field for the reservation platform.
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'OpenTable' => 'OpenTable',
                                'Quandoo' => 'Quandoo',
                                'Website' => 'Website',
                            ])
                            ->required(), // This field is mandatory.
                        // Text input for the reservation link URL.
                        Forms\Components\TextInput::make('link')
                            ->label('Link')
                            ->url(), // Validates as a URL.
                        // Text input for the name associated with the reservation link.
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->nullable(),
                    ])
                    ->columns(2), // Arranges sub-fields in two columns.

                // Repeater for managing social media accounts.
                Forms\Components\Repeater::make('media_social')
                    ->label('Social Media')
                    ->schema([
                        // Select field for the social media platform.
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'website' => 'Website',
                                'instagram' => 'Instagram',
                                'facebook' => 'Facebook',
                                'twitter' => 'Twitter',
                                'tiktok' => 'Tiktok',
                                'youtube' => 'Youtube',
                            ])
                            ->required(), // This field is mandatory.
                        // Text input for the social media link.
                        Forms\Components\TextInput::make('link')
                            ->label('Link')
                            ->url() // Validates as a URL.
                            ->required(), // This field is mandatory.
                    ])
                    ->columns(2), // Arranges sub-fields in two columns.

                // Text inputs for business location (Google Maps link, Latitude, Longitude).
                Forms\Components\TextInput::make('location')
                    ->label('Google Maps Link')
                    ->required() // This field is mandatory.
                    ->reactive(), // Reacts to changes for potential auto-filling of lat/long.

                Forms\Components\TextInput::make('latitude')
                    ->label('Latitude')
                    ->nullable()
                    ->reactive()
                    ->placeholder('Enter latitude manually'),

                Forms\Components\TextInput::make('longitude')
                    ->label('Longitude')
                    ->nullable()
                    ->reactive()
                    ->placeholder('Enter longitude manually'),

                // Text input for an iframe URL to embed the business location.
                Forms\Components\TextInput::make('iframe_url')
                    ->label('Iframe Business Location')
                    ->maxLength(2048), // Maximum length for the URL.

                // Repeater for contact details.
                Forms\Components\Repeater::make('contact')
                    ->label('Contact')
                    ->schema([
                        // Select field for the contact type (e.g., Email, WhatsApp).
                        Forms\Components\Select::make('type')
                            ->label('Contact Type')
                            ->options([
                                'email' => 'Email',
                                'wa' => 'WhatsApp',
                                'telp' => 'Telephone',
                                'telegram' => 'Telegram',
                            ])
                            ->required(), // This field is mandatory.
                        // Text input for the contact details (link or number).
                        Forms\Components\TextInput::make('details')
                            ->label('Link or Number Contact')
                            ->required(), // This field is mandatory.
                    ])
                    ->columns(2), // Arranges sub-fields in two columns.

                // Repeater for managing business image galleries.
                Forms\Components\Repeater::make('galleries')
                    ->label('Gallery')
                    ->relationship('galleries') // Defines a relationship to the 'galleries' model.
                    ->schema([
                        // Text input for the gallery image title.
                        Forms\Components\TextInput::make('title')
                            ->label('Gallery Title')
                            ->required(), // This field is mandatory.
                        // File upload for the gallery image.
                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->directory('gallery-images') // Stores uploaded images in 'gallery-images'.
                            ->required(), // This field is mandatory.
                    ])
                    ->columns(1), // Arranges sub-fields in a single column.

                // Repeater for managing business products.
                Forms\Components\Repeater::make('products')
                    ->label('Products')
                    ->relationship('products') // Defines a relationship to the 'products' model.
                    ->schema([
                        // Text input for the product name.
                        Forms\Components\TextInput::make('name')
                            ->label('Product Name')
                            ->required(), // This field is mandatory.

                        // File upload for the product image.
                        Forms\Components\FileUpload::make('image')
                            ->label('Product Image')
                            ->directory('product-images'), // Stores uploaded images in 'product-images'.

                        // Select field for the product type (Food or Drink).
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options([
                                'food' => 'Food',
                                'drink' => 'Drink',
                            ])
                            ->required(), // This field is mandatory.

                        // Text input for product serving information.
                        Forms\Components\TextInput::make('serving')
                            ->label('Serving'),

                        // Numeric input for the product price.
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric() // Ensures the input is a number.
                            ->required(), // This field is mandatory.

                        // Textarea for product description.
                        Forms\Components\Textarea::make('desc')
                            ->label('Description'),

                        // Nested repeater for product variants.
                        Forms\Components\Repeater::make('variants')
                            ->label('Variants')
                            ->schema([
                                // Text input for variant name.
                                Forms\Components\TextInput::make('name')
                                    ->label('Variant Name')
                                    ->required(), // This field is mandatory.
                                // Numeric input for variant price.
                                Forms\Components\TextInput::make('price')
                                    ->label('Variant Price')
                                    ->numeric() // Ensures the input is a number.
                                    ->required(), // This field is mandatory.
                            ])
                            ->default([]) // Defaults to an empty array if no variants.
                            ->collapsed() // Starts collapsed in the UI.
                            ->grid(2), // Arranges variant sub-fields in two columns.
                    ])
                    ->columns(1), // Arranges product sub-fields in a single column.
            ]);
    }

    /**
     * Defines the table structure for displaying business records.
     *
     * @param Table $table The table instance.
     * @return Table The configured table instance.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Text column for unique business code, sortable.
                Tables\Columns\TextColumn::make('unique_code')
                    ->sortable(),
                // Text column for business name, searchable and sortable.
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                // Text column for business type, displays the 'title' from the 'type' relationship.
                Tables\Columns\TextColumn::make('type_id')
                    ->label('Type Business')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state, $record) => $record->type?->title ?? '-') // Formats the display to show type title, or '-' if not available.
                    ->limit(20), // Limits the displayed text to 20 characters.
                // Text column for business description, limited to 50 characters.
                Tables\Columns\TextColumn::make('description')->limit(50),
                // Text column for business address, limited to 50 characters.
                Tables\Columns\TextColumn::make('address')->limit(50),
                // Text column for business country, searchable and sortable.
                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->sortable(),
                // Text column for business city, searchable and sortable.
                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->sortable(),
                // Text column for the business document (sticker), provides a download link.
                Tables\Columns\TextColumn::make('document')
                    ->url(fn($record) => asset('storage/' . $record->document), true) // Generates a direct URL to the document.
                    ->label('Download Sticker'),
                // Text column for creation timestamp, formatted as date and time.
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])
            // Define header actions (buttons above the table).
            ->headerActions([
                // Action to export all businesses to Excel.
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray') // Icon for download.
                    ->url(route('export-businesses')) // Route for the export.
                    ->openUrlInNewTab() // Opens the export in a new tab.
                    ->color('success'), // Green button color.

                // Action to export all businesses to PDF.
                Action::make('export_all_pdf')
                    ->label('Export All Businesses PDF')
                    ->icon('heroicon-o-document-arrow-down') // Icon for PDF download.
                    ->color('success') // Green button color.
                    ->action(function () {
                        // Load all business data with their related types, QR links, galleries, and products.
                        $businesses = Business::with(['type', 'qrLink', 'galleries', 'products'])->get();

                        // Load the 'exports.businesses-pdf' view with the business data and set paper size/orientation.
                        $pdf = Pdf::loadView('exports.businesses-pdf', [
                            'businesses' => $businesses,
                        ])->setPaper('a4', 'landscape');

                        // Stream the PDF as a download.
                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            'all-businesses.pdf'
                        );
                    }),
            ])
            // Define table filters.
            ->filters([
                // Filter for trashed (soft-deleted) records.
                TrashedFilter::make(),
                // Select filter for business type.
                SelectFilter::make('type_id')
                    ->label('Type Business')
                    ->relationship('type', 'title') // Filters by the 'title' of the related 'type'.
                    ->preload() // Preloads options.
                    ->searchable(), // Allows searching within filter options.
                // Multi-select filter for food categories.
                SelectFilter::make('food_categories')
                    ->label('Food Categories')
                    ->relationship('food_categories', 'title') // Filters by the 'title' of related 'food_categories'.
                    ->preload() // Preloads options.
                    ->multiple(), // Allows selecting multiple categories to filter by.
            ])
            // Define row actions (actions for individual records).
            ->actions([
                Tables\Actions\ViewAction::make(), // Action to view a business record.
                Tables\Actions\EditAction::make(), // Action to edit a business record.
                Tables\Actions\DeleteAction::make(), // Action to soft-delete a business record.
                // Custom action to generate a sticker PDF for a single business.
                Tables\Actions\Action::make('generate_sticker')
                    ->label('Generate Sticker')
                    ->action(fn($record) => app(StickerController::class)->generate($record)) // Calls the generate method on StickerController.
                    ->color('primary') // Blue button color.
                    ->hidden(fn($record) => empty($record->unique_code)), // Hides the button if 'unique_code' is empty.
                // Action to export a single business record to PDF.
                Action::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down') // Icon for PDF download.
                    ->color('danger') // Red button color.
                    ->url(fn($record) => route('export-business.pdf.single', $record->id)) // Route for single PDF export.
                    ->openUrlInNewTab(), // Opens the PDF in a new tab.
                Tables\Actions\RestoreAction::make(),     // Action to restore a soft-deleted record.
                Tables\Actions\ForceDeleteAction::make(), // Action to permanently delete a record.
            ])
            // Define bulk actions (actions for multiple selected records).
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Bulk action to soft-delete multiple records.
                    Tables\Actions\RestoreBulkAction::make(),      // Bulk action to restore multiple soft-deleted records.
                    Tables\Actions\ForceDeleteBulkAction::make(),  // Bulk action to permanently delete multiple records.
                    // Bulk action to export multiple selected businesses to PDF.
                    Tables\Actions\BulkAction::make('export_pdf')
                        ->label('Export PDF')
                        ->icon('heroicon-o-document-arrow-down') // Icon for PDF download.
                        ->color('danger') // Red button color.
                        ->action(function (\Illuminate\Support\Collection $records) {
                            // Load selected business data with their relationships.
                            $businesses = $records->load(['type', 'qrLink', 'galleries', 'products']);

                            // Load the 'exports.businesses-pdf' view with the selected business data and set paper size/orientation.
                            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.businesses-pdf', [
                                'businesses' => $businesses,
                            ])->setPaper('a4', 'landscape');

                            // Stream the PDF as a download.
                            return response()->streamDownload(
                                fn() => print($pdf->output()),
                                'bulk-businesses.pdf'
                            );
                        }),
                ]),
            ]);
    }

    /**
     * Defines the relationships to be managed with this resource.
     * Currently, no relation managers are defined.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Defines the pages associated with this resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBusinesses::route('/'), // List all businesses.
            'create' => Pages\CreateBusiness::route('/create'), // Form to create a new business.
            'edit' => Pages\EditBusiness::route('/{record}/edit'), // Form to edit an existing business.
        ];
    }
}
