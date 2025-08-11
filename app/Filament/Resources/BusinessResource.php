<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers;
use App\Http\Controllers\StickerController; // Unused import: StickerController is not directly used in this Filament Resource.
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope; // Unused import: SoftDeletingScope is not directly applied in the table query here.
use Filament\Tables\Filters\SelectFilter;
use Barryvdh\DomPDF\Facade\Pdf; // Unused import: Pdf facade is not directly used for PDF generation within this class.
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MultiSelect;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;

/**
 * BusinessResource
 *
 * This class defines the Filament administrative interface for the Business model.
 * It manages how business records are displayed, created, edited, and deleted in the admin panel.
 *
 * Filament Resources provide a quick way to build admin panels for your Eloquent models.
 * They handle common CRUD (Create, Read, Update, Delete) operations with minimal code.
 */
class BusinessResource extends Resource
{
    /**
     * The Eloquent model associated with this resource.
     *
     * This property tells Filament which database model this resource will manage.
     *
     * @var string|null
     */
    protected static ?string $model = Business::class;

    /**
     * Get the navigation badge value.
     *
     * This method displays the total count of business records next to the navigation item
     * in the Filament sidebar, providing a quick overview of the number of entries.
     *
     * @return string|null The count of business records, or null if not needed.
     */
    public static function getNavigationBadge(): ?string
    {
        // Counts all records in the 'businesses' table.
        return Business::count();
    }

    /**
     * The navigation group for this resource.
     * Resources within the same group will be displayed together in the navigation
     * sidebar, helping to organize the admin panel.
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Business Operations';

    /**
     * The sort order for this resource in the navigation.
     * Lower numbers appear higher in the navigation menu, allowing for custom ordering
     * of resources in the sidebar.
     *
     * @var int|null
     */
    protected static ?int $navigationSort = 2;

    /**
     * The navigation icon for the resource.
     * Uses a Heroicons icon to visually represent the Business resource in the sidebar.
     * You can find available icons at https://heroicons.com.
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    /**
     * Defines the form schema for creating and editing Business records.
     *
     * This method configures all the input fields and their properties (e.g., labels,
     * validation rules, relationships) that users will interact with when adding
     * or modifying business information. It uses Filament's Form Builder.
     *
     * @param Form $form The form instance to configure.
     * @return Form The configured form instance with defined fields.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main Tabs component for organizing business information into logical sections.
                Forms\Components\Tabs::make('Business Information')
                    ->tabs([
                        // Tab 1: Basic Information
                        // Contains fundamental details about the business.
                        Forms\Components\Tabs\Tab::make('Basic Information')
                            ->icon('heroicon-o-information-circle') // Icon for this tab.
                            ->schema([
                                // Group for Business Type and Unique Code, displayed in two columns.
                                Forms\Components\Group::make()
                                    ->schema([
                                        // Select field for 'Business Type', related to the 'type' model.
                                        Forms\Components\Select::make('type_id')
                                            ->label('Business Type')
                                            ->relationship('type', 'title') // Establishes a relationship to fetch types.
                                            ->required() // This field is mandatory.
                                            ->placeholder('Select business type'),

                                        // Text input for 'Unique Code'.
                                        Forms\Components\TextInput::make('unique_code')
                                            ->label('Unique Code')
                                            ->nullable() // This field is optional.
                                            ->placeholder('Enter unique code'),
                                    ])
                                    ->columns(2), // Arranges fields in two columns within this group.

                                // Group for Business Name and Food Categories, displayed in two columns.
                                Forms\Components\Group::make()
                                    ->schema([
                                        // Text input for 'Business Name'.
                                        Forms\Components\TextInput::make('name')
                                            ->label('Business Name')
                                            ->required() // This field is mandatory.
                                            ->placeholder('Enter business name'),

                                        // Multi-select field for 'Food Categories', related to 'food_categories'.
                                        Forms\Components\Select::make('food_categories')
                                            ->label('Food Categories')
                                            ->relationship('food_categories', 'title') // Establishes a relationship to fetch categories.
                                            ->multiple() // Allows selection of multiple categories.
                                            ->preload() // Loads all options initially for a better user experience.
                                            ->placeholder('Select food categories'),
                                    ])
                                    ->columns(2), // Arranges fields in two columns within this group.

                                // Textarea for 'Business Description'.
                                Forms\Components\Textarea::make('description')
                                    ->label('Business Description')
                                    ->placeholder('Describe your business')
                                    ->rows(3), // Sets the visible height of the textarea.

                                // File upload field for 'Business Logo'.
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Business Logo')
                                    ->directory('logos') // Specifies the storage directory for uploaded logos.
                                    ->image() // Restricts uploads to image files.
                                    ->imageEditor() // Enables an image editor for cropping/resizing.
                                    ->maxSize(5120), // Sets maximum file size to 5MB (5120 KB).
                            ]),

                        // Tab 2: Location & Contact
                        // Manages geographical location and communication details.
                        Forms\Components\Tabs\Tab::make('Location & Contact')
                            ->icon('heroicon-o-map-pin') // Icon for this tab.
                            ->schema([
                                // Section for 'Location Information'.
                                Forms\Components\Section::make('Location Information')
                                    ->schema([
                                        // Group for Country and City, displayed in two columns.
                                        Forms\Components\Group::make()
                                            ->schema([
                                                // Text input for 'Country'.
                                                Forms\Components\TextInput::make('country')
                                                    ->label('Country')
                                                    ->placeholder('Enter country'),

                                                // Text input for 'City'.
                                                Forms\Components\TextInput::make('city')
                                                    ->label('City')
                                                    ->placeholder('Enter city'),
                                            ])
                                            ->columns(2), // Arranges fields in two columns within this group.

                                        // Textarea for 'Full Address'.
                                        Forms\Components\Textarea::make('address')
                                            ->label('Full Address')
                                            ->required() // This field is mandatory.
                                            ->placeholder('Enter complete address')
                                            ->rows(2), // Sets the visible height of the textarea.

                                        // Group for Google Maps Link and Iframe Embed URL, displayed in two columns.
                                        Forms\Components\Group::make()
                                            ->schema([
                                                // Text input for 'Google Maps Link'.
                                                Forms\Components\TextInput::make('location')
                                                    ->label('Google Maps Link')
                                                    ->required() // This field is mandatory.
                                                    ->url() // Validates input as a URL.
                                                    ->reactive() // Updates other fields based on this input.
                                                    ->placeholder('https://maps.google.com/...'),

                                                // Text input for 'Iframe Embed URL'.
                                                Forms\Components\TextInput::make('iframe_url')
                                                    ->label('Iframe Embed URL')
                                                    ->maxLength(2048) // Sets maximum length for the URL.
                                                    ->placeholder('Maps iframe embed URL'),
                                            ])
                                            ->columns(2), // Arranges fields in two columns within this group.

                                        // Group for Latitude and Longitude, displayed in two columns.
                                        Forms\Components\Group::make()
                                            ->schema([
                                                // Text input for 'Latitude'.
                                                Forms\Components\TextInput::make('latitude')
                                                    ->label('Latitude')
                                                    ->nullable() // This field is optional.
                                                    ->reactive() // Updates other fields based on this input.
                                                    ->placeholder('Enter latitude'),

                                                // Text input for 'Longitude'.
                                                Forms\Components\TextInput::make('longitude')
                                                    ->label('Longitude')
                                                    ->nullable() // This field is optional.
                                                    ->reactive() // Updates other fields based on this input.
                                                    ->placeholder('Enter longitude'),
                                            ])
                                            ->columns(2), // Arranges fields in two columns within this group.
                                    ]),

                                // Section for 'Contact Information'.
                                Forms\Components\Section::make('Contact Information')
                                    ->schema([
                                        // Repeater for 'Contact Details', allowing multiple contact entries.
                                        Forms\Components\Repeater::make('contact')
                                            ->label('Contact Details')
                                            ->schema([
                                                // Select field for 'Contact Type' (e.g., Email, WhatsApp).
                                                Forms\Components\Select::make('type')
                                                    ->label('Contact Type')
                                                    ->options([ // Predefined options for contact types.
                                                        'email' => 'Email',
                                                        'wa' => 'WhatsApp',
                                                        'telp' => 'Telephone',
                                                        'telegram' => 'Telegram',
                                                    ])
                                                    ->required(), // This field is mandatory.

                                                // Text input for 'Contact Details' (e.g., email address, phone number).
                                                Forms\Components\TextInput::make('details')
                                                    ->label('Contact Details')
                                                    ->required() // This field is mandatory.
                                                    ->placeholder('Enter contact information'),
                                            ])
                                            ->columns(2) // Arranges fields in two columns within each repeated item.
                                            ->defaultItems(1) // Starts with one default item.
                                            ->collapsible(), // Allows collapsing of individual repeater items.
                                    ]),
                            ]),

                        // Tab 3: Business Operations
                        // Details related to how the business operates.
                        Forms\Components\Tabs\Tab::make('Operations')
                            ->icon('heroicon-o-clock') // Icon for this tab.
                            ->schema([
                                // Section for 'Operating Hours'.
                                Forms\Components\Section::make('Operating Hours')
                                    ->schema([
                                        // Key-Value field for 'Business Hours', allowing dynamic input for days and hours.
                                        Forms\Components\KeyValue::make('open_hours')
                                            ->label('Business Hours')
                                            ->keyLabel('Day') // Label for the key column (e.g., "Monday").
                                            ->valueLabel('Hours') // Label for the value column (e.g., "9:00 AM - 6:00 PM").
                                    ]),

                                // Section for 'Services'.
                                Forms\Components\Section::make('Services')
                                    ->schema([
                                        // Checkbox list for 'Available Services'.
                                        Forms\Components\CheckboxList::make('services')
                                            ->label('Available Services')
                                            ->options([ // Predefined options for services.
                                                'Dine In' => 'Dine In',
                                                'Delivery' => 'Delivery',
                                            ])
                                            ->columns(2), // Arranges checkboxes in two columns.
                                    ]),

                                // Section for 'Menu & Documents'.
                                Forms\Components\Section::make('Menu & Documents')
                                    ->schema([
                                        // File upload for 'Menu List' (PDF or images).
                                        Forms\Components\FileUpload::make('menu')
                                            ->label('Menu List')
                                            ->directory('menu') // Specifies the storage directory for menus.
                                            ->acceptedFileTypes(['application/pdf', 'image/*']) // Accepts PDF and image files.
                                            ->maxSize(10240), // Sets maximum file size to 10MB.

                                        // File upload for 'Business Sticker (PDF)'.
                                        Forms\Components\FileUpload::make('document')
                                            ->label('Business Sticker (PDF)')
                                            ->directory('documents') // Specifies the storage directory for documents.
                                            ->acceptedFileTypes(['application/pdf']) // Accepts only PDF files.
                                            ->maxSize(10240), // Sets maximum file size to 10MB.
                                    ]),
                            ]),

                        // Tab 4: QR Code & Links
                        // Manages QR codes and external ordering/reservation links.
                        Forms\Components\Tabs\Tab::make('QR Code & Links')
                            ->icon('heroicon-o-qr-code') // Icon for this tab.
                            ->schema([
                                // Section for 'QR Code Management'.
                                Forms\Components\Section::make('QR Code Management')
                                    ->schema([
                                        // Select field for 'QR Code', related to the 'qrLink' model.
                                        Forms\Components\Select::make('qr_link_id')
                                            ->label('QR Code')
                                            ->relationship('qrLink', 'name') // Establishes a relationship to fetch QR links.
                                            ->searchable() // Allows searching within the QR code options.
                                            ->preload() // Loads all options initially.
                                            ->placeholder('Select QR code'),

                                        // Placeholder to display a preview of the selected QR code.
                                        Forms\Components\Placeholder::make('qr_display')
                                            ->label('QR Code Preview')
                                            ->content(function ($record) {
                                                // Checks if a QR code is assigned and has a path.
                                                if (!$record || !$record->qrLink || !$record->qrLink->qr_path) {
                                                    // Displays a message if no QR code is assigned.
                                                    return new \Illuminate\Support\HtmlString(
                                                        '<div class="text-center p-4 border border-gray-300 rounded-lg bg-gray-50">'
                                                            . '<p class="text-gray-500">No QR Code Assigned</p>'
                                                            . '</div>'
                                                    );
                                                }

                                                // Generates the full URL for the QR code image.
                                                $url = asset('storage/' . $record->qrLink->qr_path);
                                                // Displays the QR code image and its URL.
                                                return new \Illuminate\Support\HtmlString(
                                                    '<div class="text-center p-4 border border-gray-300 rounded-lg">'
                                                        . '<img src="' . $url . '" style="width:150px; height:150px; margin: 0 auto;" class="rounded" />'
                                                        . '<p class="text-sm text-gray-600 mt-2">' . $url . '</p>'
                                                        . '</div>'
                                                );
                                            })
                                            ->reactive(), // Updates when `qr_link_id` changes.
                                    ]),

                                // Section for 'Order Links'.
                                Forms\Components\Section::make('Order Links')
                                    ->schema([
                                        // Repeater for 'Online Ordering Platforms', allowing multiple links.
                                        Forms\Components\Repeater::make('order')
                                            ->label('Online Ordering Platforms')
                                            ->schema([
                                                // Select field for 'Platform' (e.g., Menulog, DoorDash).
                                                Forms\Components\Select::make('platform')
                                                    ->label('Platform')
                                                    ->options([ // Predefined options for ordering platforms.
                                                        'Menulog' => 'Menulog',
                                                        'DoorDash' => 'DoorDash',
                                                        'UberEAST' => 'UberEAST',
                                                        'Abacus' => 'Abacus',
                                                        'Fantuan' => 'Fantuan',
                                                        'Website' => 'Website',
                                                        'HungryPanda' => 'HungryPanda',
                                                    ])
                                                    ->required(), // This field is mandatory.

                                                // Text input for 'Order Link'.
                                                Forms\Components\TextInput::make('link')
                                                    ->label('Order Link')
                                                    ->url() // Validates input as a URL.
                                                    ->placeholder('https://...'),

                                                // Text input for 'Display Name' for the link.
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Display Name')
                                                    ->nullable() // This field is optional.
                                                    ->placeholder('Optional display name'),
                                            ])
                                            ->columns(3) // Arranges fields in three columns within each repeated item.
                                            ->collapsible() // Allows collapsing of individual repeater items.
                                            ->defaultItems(0), // Starts with no default items.
                                    ]),

                                // Section for 'Reservation Links'.
                                Forms\Components\Section::make('Reservation Links')
                                    ->schema([
                                        // Repeater for 'Reservation Platforms', allowing multiple links.
                                        Forms\Components\Repeater::make('reserve')
                                            ->label('Reservation Platforms')
                                            ->schema([
                                                // Select field for 'Platform' (e.g., OpenTable, Quandoo).
                                                Forms\Components\Select::make('platform')
                                                    ->label('Platform')
                                                    ->options([ // Predefined options for reservation platforms.
                                                        'OpenTable' => 'OpenTable',
                                                        'Quandoo' => 'Quandoo',
                                                        'Website' => 'Website',
                                                    ])
                                                    ->required(), // This field is mandatory.

                                                // Text input for 'Reservation Link'.
                                                Forms\Components\TextInput::make('link')
                                                    ->label('Reservation Link')
                                                    ->url() // Validates input as a URL.
                                                    ->placeholder('https://...'),

                                                // Text input for 'Display Name' for the link.
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Display Name')
                                                    ->nullable() // This field is optional.
                                                    ->placeholder('Optional display name'),
                                            ])
                                            ->columns(3) // Arranges fields in three columns within each repeated item.
                                            ->collapsible() // Allows collapsing of individual repeater items.
                                            ->defaultItems(0), // Starts with no default items.
                                    ]),
                            ]),

                        // Tab 5: Social Media
                        // Manages social media profiles for the business.
                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share') // Icon for this tab.
                            ->schema([
                                // Section for 'Social Media Accounts'.
                                Forms\Components\Section::make('Social Media Accounts')
                                    ->schema([
                                        // Repeater for 'Social Media Links', allowing multiple entries.
                                        Forms\Components\Repeater::make('media_social')
                                            ->label('Social Media Links')
                                            ->schema([
                                                // Select field for 'Platform' (e.g., Instagram, Facebook).
                                                Forms\Components\Select::make('platform')
                                                    ->label('Platform')
                                                    ->options([ // Predefined options for social media platforms.
                                                        'website' => 'Website',
                                                        'instagram' => 'Instagram',
                                                        'facebook' => 'Facebook',
                                                        'twitter' => 'Twitter',
                                                        'tiktok' => 'TikTok',
                                                        'youtube' => 'YouTube',
                                                    ])
                                                    ->required(), // This field is mandatory.

                                                // Text input for 'Profile Link'.
                                                Forms\Components\TextInput::make('link')
                                                    ->label('Profile Link')
                                                    ->url() // Validates input as a URL.
                                                    ->required() // This field is mandatory.
                                                    ->placeholder('https://...'),
                                            ])
                                            ->columns(2) // Arranges fields in two columns within each repeated item.
                                            ->defaultItems(1) // Starts with one default item.
                                            ->collapsible(), // Allows collapsing of individual repeater items.
                                    ])
                                    ->description('Add your social media profiles to help customers connect with you'),
                            ]),

                        // Tab 6: Gallery & Products
                        // Manages image galleries and menu product listings.
                        Forms\Components\Tabs\Tab::make('Gallery & Products')
                            ->icon('heroicon-o-photo') // Icon for this tab.
                            ->schema([
                                // Section for 'Image Gallery'.
                                Forms\Components\Section::make('Image Gallery')
                                    ->schema([
                                        // Repeater for 'Business Gallery' images, related to the 'galleries' relationship.
                                        Forms\Components\Repeater::make('galleries')
                                            ->label('Business Gallery')
                                            ->relationship('galleries') // Links to the 'galleries' Eloquent relationship.
                                            ->schema([
                                                // Text input for 'Image Title'.
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Image Title')
                                                    ->required() // This field is mandatory.
                                                    ->placeholder('Enter image title'),

                                                // File upload for 'Image'.
                                                Forms\Components\FileUpload::make('image')
                                                    ->label('Image')
                                                    ->directory('gallery-images') // Specifies the storage directory for gallery images.
                                                    ->image() // Restricts uploads to image files.
                                                    ->imageEditor() // Enables an image editor.
                                                    ->required() // This field is mandatory.
                                                    ->maxSize(5120), // Sets maximum file size to 5MB.
                                            ])
                                            ->columns(2) // Arranges fields in two columns within each repeated item.
                                            ->collapsible() // Allows collapsing of individual repeater items.
                                            ->defaultItems(0), // Starts with no default items.
                                    ])
                                    ->description('Showcase your business with beautiful images'),

                            ]),

                    ])
                    ->columnSpanFull() // Makes the tabs span the full width of the form.
                    ->persistTabInQueryString(), // Retains the active tab across page loads via URL query string.


                Forms\Components\Tabs::make('Business Product Management')
                    ->tabs([
                        // Tab Produk
                        Tabs\Tab::make('Product Management')
                            ->schema([
                                Forms\Components\Section::make('Menu Products')
                                    ->schema([
                                        Forms\Components\Repeater::make('products')
                                            ->relationship('products')
                                            ->schema([
                                                Forms\Components\TextInput::make('name')->required(),
                                                Forms\Components\FileUpload::make('image')
                                                    ->image()->directory('product-images'),
                                                Forms\Components\TextInput::make('price')
                                                    ->numeric()->prefix('$'),
                                                Forms\Components\TextInput::make('serving'),
                                                Forms\Components\Textarea::make('desc'),

                                                Forms\Components\TextInput::make('max_distance')
                                                    ->label('Max Distance (km)')
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->helperText('Produk hanya tersedia dalam radius ini dari lokasi user'),

                                                // OPTION GROUPS (many-to-many)
                                                MultiSelect::make('optionGroups')
                                                    ->label('Option Groups')
                                                    ->relationship(
                                                        name: 'optionGroups',
                                                        titleAttribute: 'name',
                                                        modifyQueryUsing: fn(\Illuminate\Database\Eloquent\Builder $query, callable $get) =>
                                                        $query->where('business_id', $get('../../id')),
                                                    ),


                                                // CATEGORIES (many-to-many)
                                                MultiSelect::make('categories')
                                                    ->label('Categories')
                                                    ->relationship(
                                                        name: 'categories',
                                                        titleAttribute: 'name',
                                                        modifyQueryUsing: fn(\Illuminate\Database\Eloquent\Builder $query, callable $get) =>
                                                        $query->where('business_id', $get('../../id')), // Mengambil ID dari parent Business
                                                    )

                                            ])
                                            ->collapsed()
                                            ->columns(1),
                                    ]),
                            ]),


                        // Tab Option Group
                        Forms\Components\Tabs\Tab::make('Product Option Groups')
                            ->schema([
                                Forms\Components\Section::make('Product Option Groups')
                                    ->schema([
                                        Forms\Components\Repeater::make('productOptionGroups')
                                            ->relationship('productOptionGroups') // <- relasi business -> group
                                            ->schema([
                                                Forms\Components\TextInput::make('name')->required(),
                                                Forms\Components\Toggle::make('is_required'),
                                                Forms\Components\TextInput::make('max_selection')->numeric(),
                                                Forms\Components\Repeater::make('options')
                                                    ->relationship('options') // <- relasi group -> options
                                                    ->schema([
                                                        Forms\Components\TextInput::make('name')->required(),
                                                        Forms\Components\TextInput::make('price')
                                                            ->label('Additional Price')
                                                            ->numeric()
                                                            ->prefix('+ $')
                                                            ->default(0),
                                                    ]),
                                            ]),
                                    ])
                            ]),

                        // Tab Kategori
                        Forms\Components\Tabs\Tab::make('Categories')
                            ->schema([
                                Forms\Components\Section::make('Product Categories')
                                    ->schema([
                                        Forms\Components\Repeater::make('categories')
                                            ->relationship('categories') // <- relasi business -> categories
                                            ->schema([
                                                Forms\Components\TextInput::make('name')->required(),
                                            ])
                                    ]),
                            ]),


                    ])
                    ->columnSpanFull() // Makes the tabs span the full width of the form.
                    ->persistTabInQueryString(), // Retains the active tab across page loads via URL query string.
            ]);
    } 

    /**
     * Defines the table structure for displaying business records.
     * This method configures all columns, actions, filters, and other table behaviors.
     *
     * @param Table $table The table instance provided by Filament.
     * @return Table The configured table instance.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Displays the business ID.
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible.

                Tables\Columns\TextColumn::make('user_id')
                    ->label('Status Klaim')
                    ->badge() // Aktifkan tampilan badge
                    ->formatStateUsing(function ($state) {
                        return $state === null ? 'Belum diklaim' : 'Sudah diklaim';
                    })
                    ->color(function ($state) {
                        return $state === null ? 'warning' : 'success';
                    }),

                // Displays the business logo.
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo') // Column header label
                    ->circular() // Makes the image circular
                    ->size(50) // Sets image size to 50x50 pixels
                    // Default image if no logo is uploaded. 'asset()' helper points to public directory.
                    ->defaultImageUrl(asset('images/default-business.png')),

                // Displays the business name with additional details.
                Tables\Columns\TextColumn::make('name')
                    ->label('Business Name') // Column header label
                    ->searchable() // Allows searching by business name
                    ->sortable() // Allows sorting by business name
                    ->weight('bold') // Makes the business name text bold
                    // Adds a description below the business name, showing ID and business type.
                    ->description(function ($record) {
                        $parts = []; // Array to hold description parts

                        // Add Business ID if available.
                        if ($record->id) {
                            $parts[] = "ID: #{$record->id}";
                        }

                        // Add Business Type title if available (e.g., 'Restaurant', 'Cafe').
                        // 'type?' is a null-safe operator in case the 'type' relationship is null.
                        if ($record->type?->title) {
                            $parts[] = $record->type->title;
                        }

                        // Implode parts with ' • ' separator, or show 'No additional info' if empty.
                        return !empty($parts) ? implode(' • ', $parts) : 'No additional info';
                    }),

                // Displays the business location (City, Country).
                Tables\Columns\TextColumn::make('location_display')
                    ->label('Location') // Column header label
                    // Custom state generation for location, combining city and country.
                    ->state(function ($record) {
                        // Collect city and country, filter out null/empty values, then join with ', '.
                        $location = collect([$record->city, $record->country])
                            ->filter() // Remove empty strings or nulls
                            ->implode(', '); // Join with comma and space
                        return $location ?: 'No Location'; // Show 'No Location' if both are empty
                    })
                    ->icon('heroicon-o-map-pin') // Adds a map pin icon next to the location
                    ->searchable(['city', 'country']) // Allows searching by city and country fields
                    ->sortable(), // Allows sorting by location (based on the combined state)

                // Displays associated food categories as badges.
                Tables\Columns\TextColumn::make('food_categories.title')
                    ->label('Categories') // Column header label
                    ->badge() // Renders each category as a badge
                    ->color('info') // Sets the badge color to 'info' (typically blue/light blue)
                    ->separator(',') // Uses comma as a separator if multiple categories are displayed directly
                    // Provides a tooltip showing all categories when hovering over the column.
                    ->tooltip(function ($record) {
                        // Plucks 'title' from food_categories relationship and joins them.
                        return $record->food_categories->pluck('title')->implode(', ');
                    }),

                // Displays available services as colored badges.
                Tables\Columns\TextColumn::make('services')
                    ->label('Services') // Column header label
                    ->badge() // Renders service(s) as a badge
                    // Dynamically sets badge color based on service types.
                    ->color(fn($state) => match (true) {
                        // If both Delivery and Dine In are present.
                        str_contains($state, 'Delivery') && str_contains($state, 'Dine In') => 'success',
                        // If only Delivery is present.
                        str_contains($state, 'Delivery') => 'warning',
                        // If only Dine In is present.
                        str_contains($state, 'Dine In') => 'primary',
                        default => 'gray' // Default color for other cases or no services.
                    })
                    // Formats the state for display. Handles array services by joining them.
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return implode(', ', $state); // Joins array elements with comma and space.
                        }
                        return $state ?? 'No Services'; // Returns state or 'No Services' if null.
                    }),

                // Indicates if a QR code is assigned to the business.
                Tables\Columns\IconColumn::make('has_qr_code')
                    ->label('QR Code') // Column header label
                    ->boolean() // Displays as a boolean icon (check/cross)
                    ->trueIcon('heroicon-o-qr-code') // Icon for true (QR code exists)
                    ->falseIcon('heroicon-o-x-circle') // Icon for false (no QR code)
                    ->trueColor('success') // Color for true (green)
                    ->falseColor('gray') // Color for false (gray)
                    // Tooltip text changes based on QR code assignment.
                    ->tooltip(fn($record) => $record->qrLink ? 'QR Code Assigned' : 'No QR Code')
                    // Determines the boolean state based on the presence of qrLink relationship.
                    ->state(fn($record) => (bool) $record->qrLink),

                // Displays the count of contact methods.
                Tables\Columns\TextColumn::make('contact_count')
                    ->label('Contacts') // Column header label
                    // Custom state to count contact methods.
                    ->state(function ($record) {
                        // Ensure 'contact' is treated as an array.
                        $contacts = is_array($record->contact) ? $record->contact : [];
                        $count = count($contacts); // Get the count of contact methods.
                        // Returns count with proper pluralization, or 'No contact'.
                        return $count > 0 ? $count . ' method' . ($count > 1 ? 's' : '') : 'No contact';
                    })
                    ->icon('heroicon-o-phone') // Adds a phone icon
                    // Sets color based on whether contacts exist.
                    ->color(fn($state) => str_contains($state, 'No contact') ? 'gray' : 'success'),

                // Displays the count of social media platforms.
                Tables\Columns\TextColumn::make('social_count')
                    ->label('Social Media') // Column header label
                    // Custom state to count social media platforms.
                    ->state(function ($record) {
                        // Ensure 'media_social' is treated as an array.
                        $socials = is_array($record->media_social) ? $record->media_social : [];
                        $count = count($socials); // Get the count.
                        // Returns count with proper pluralization, or 'None'.
                        return $count > 0 ? $count . ' platform' . ($count > 1 ? 's' : '') : 'None';
                    })
                    ->icon('heroicon-o-share') // Adds a share icon
                    // Sets color based on whether social media links exist.
                    ->color(fn($state) => str_contains($state, 'None') ? 'gray' : 'info'),

                // Displays the count of products associated with the business.
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Products') // Column header label
                    ->counts('products') // Automatically counts the 'products' relationship
                    ->icon('heroicon-o-square-3-stack-3d') // Adds an icon for products
                    ->color('warning') // Sets the column text color to warning (typically yellow/orange)
                    ->sortable(), // Allows sorting by product count

                // Displays the business profile completeness status as a badge.
                Tables\Columns\TextColumn::make('completeness_status')
                    ->label('Status') // Column header label
                    ->badge() // Renders the status as a badge
                    // Dynamically sets badge color based on completeness status.
                    ->color(fn($state) => match ($state) {
                        'Complete' => 'success', // Green for complete
                        'Good' => 'info',       // Blue for good
                        'Incomplete' => 'warning', // Yellow/Orange for incomplete
                        'Needs Work' => 'danger',  // Red for needs work
                        default => 'gray'       // Gray for unknown or other states
                    }),

                // Displays the creation date of the business record.
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created') // Column header label
                    ->dateTime('M j, Y') // Formats the date as "Month Day, Year" (e.g., Jul 24, 2025)
                    ->sortable() // Allows sorting by creation date
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible.

                // Displays the last updated date of the business record with day name and formatted time.
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated') // Column header label
                    ->dateTime('l, F d, Y \a\t ga') // Formats the date as "Monday, May 05, 2025 at 11AM"
                    ->sortable() // Allows sorting by last updated date
                    ->since() // Also displays relative time (e.g., "2 hours ago")
                    ->tooltip(
                        fn(Business $record): string =>
                        'Updated: ' . $record->updated_at->format('l, F d, Y \a\t ga') // Tooltip with full formatted date and time
                    )
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible.

            ])
            ->defaultSort('created_at', 'desc') // Default sorting: creation date, descending.
            ->headerActions([
                // Action to display quick statistics about businesses in a modal.
                Action::make('stats')
                    ->label('Business Stats') // Button label
                    ->icon('heroicon-o-chart-bar') // Icon for the button
                    ->color('info') // Button color
                    // Content of the modal when the action is clicked.
                    ->modalContent(function () {
                        // Fetch various counts for statistics.
                        $totalBusinesses = Business::count();
                        // Count businesses with a QR link assigned.
                        $withQR = Business::whereNotNull('qr_link_id')->count();
                        // Count businesses that have at least one product.
                        $withProducts = Business::has('products')->count();
                        // Group businesses by their type for a breakdown.
                        $byType = Business::with('type')->get()->groupBy('type.title');

                        // Return a Blade view with the statistics data.
                        return view('filament.pages.business-stats', compact(
                            'totalBusinesses',
                            'withQR',
                            'withProducts',
                            'byType'
                        ));
                    })
                    ->modalWidth('2xl') // Sets the modal width to 2xl
                    ->modalSubmitAction(false) // Hides the submit button in the modal
                    ->modalCancelAction(false), // Hides the cancel button in the modal

                // Action group for export options.
                Tables\Actions\ActionGroup::make([
                    // Action to export all businesses to an Excel file.
                    Action::make('export_excel')
                        ->label('Export Excel') // Button label
                        ->icon('heroicon-o-table-cells') // Icon for Excel export
                        ->url(route('export-businesses')) // URL for the export route
                        ->openUrlInNewTab() // Opens the export link in a new browser tab
                        ->color('success'), // Button color for success
                ])
                    ->label('Export') // Label for the action group dropdown
                    ->icon('heroicon-o-arrow-down-tray') // Icon for the action group dropdown
                    ->color('primary'), // Color for the action group dropdown button
            ])
            // Defines the base query for retrieving records for the table.
            ->query(function () {
                // Eager load 'products' and count them for the 'products_count' column.
                return \App\Models\Business::query()->withCount('products');
            })
            ->filters([
                // Filter businesses by their type using a select dropdown.
                SelectFilter::make('type_id')
                    ->label('Business Type') // Filter label
                    ->relationship('type', 'title') // Filters based on 'type' relationship, showing 'title'
                    ->preload() // Loads all options upfront for faster filtering
                    ->searchable() // Allows searching within the dropdown options
                    ->multiple(), // Allows selecting multiple business types

                // Filter businesses by their food categories.
                SelectFilter::make('food_categories')
                    ->label('Food Categories') // Filter label
                    ->relationship('food_categories', 'title') // Filters based on 'food_categories' relationship
                    ->preload() // Preloads all category options
                    ->multiple(), // Allows selecting multiple food categories

                // Filter to show businesses that have location information.
                Filter::make('has_location')
                    ->label('Has Location Info') // Filter label
                    // Query to filter records where both 'city' and 'country' are not null.
                    ->query(fn($query) => $query->whereNotNull('city')->whereNotNull('country'))
                    ->toggle(), // Renders as a toggle switch

                // Filter to show businesses that have a QR code assigned.
                Filter::make('has_qr_code')
                    ->label('Has QR Code') // Filter label
                    // Query to filter records where 'qr_link_id' is not null.
                    ->query(fn($query) => $query->whereNotNull('qr_link_id'))
                    ->toggle(), // Renders as a toggle switch

                // Filter to show businesses that have associated products.
                Filter::make('has_products')
                    ->label('Has Products') // Filter label
                    // Query to filter records that have at least one product.
                    ->query(fn($query) => $query->has('products'))
                    ->toggle(), // Renders as a toggle switch

                // Filter for business profile completeness status.
                Filter::make('completeness_status')
                    ->label('Profile Completeness') // Filter label
                    ->form([
                        // Select dropdown for completeness status options.
                        Select::make('value')
                            ->label('Status') // Label for the select dropdown
                            ->options([
                                'Complete' => 'Complete (90%+)',
                                'Good' => 'Good (70-89%)',
                                'Incomplete' => 'Incomplete (50-69%)',
                                'Needs Work' => 'Needs Work (<50%)',
                            ]),
                    ])
                    // Custom query logic for filtering by completeness status.
                    ->query(function ($query, array $data) {
                        // If no value is selected, return the original query.
                        if (!isset($data['value']) || !$data['value']) return $query;

                        // Retrieve all records first, then filter them by the calculated completeness status.
                        // This approach is necessary because 'completeness_status' is a computed attribute,
                        // not a direct database column.
                        $filteredIds = $query->get()->filter(function ($record) use ($data) {
                            return $record->completeness_status === $data['value'];
                        })->pluck('id'); // Get the IDs of the filtered records.

                        // Filter the original query by the collected IDs.
                        return $query->whereIn('id', $filteredIds);
                    }),

                // Date range filter for creation date.
                Filter::make('created_at')
                    ->form([
                        // Date picker for the start date.
                        DatePicker::make('created_from')
                            ->label('Created From'),
                        // Date picker for the end date.
                        DatePicker::make('created_until')
                            ->label('Created Until'),
                    ])
                    // Query logic for date range filtering.
                    ->query(function ($query, array $data) {
                        return $query
                            // Apply 'whereDate' condition if 'created_from' is provided.
                            ->when($data['created_from'], fn($q) => $q->whereDate('created_at', '>=', $data['created_from']))
                            // Apply 'whereDate' condition if 'created_until' is provided.
                            ->when($data['created_until'], fn($q) => $q->whereDate('created_at', '<=', $data['created_until']));
                    }),
            ])
            ->actions([
                // Action to display a quick view modal of the business.
                Tables\Actions\ViewAction::make('quick_view')
                    ->label('Quick View') // Button label
                    ->icon('heroicon-o-eye') // Eye icon
                    ->color('info') // Information color
                    // Content of the modal, loading a Blade view for quick view.
                    ->modalContent(fn($record) => view('filament.modals.business-quick-view', ['business' => $record]))
                    ->modalWidth('4xl'), // Sets the modal width to 4xl

                // Standard edit action for a record.
                Tables\Actions\EditAction::make()
                    ->color('warning'), // Warning color for edit button

                // Action to manage/view QR code.
                Tables\Actions\Action::make('manage_qr')
                    ->label('QR Code') // Button label
                    ->icon('heroicon-o-qr-code') // QR code icon
                    // Color changes based on whether a QR code is assigned.
                    ->color(fn($record) => $record->qrLink ? 'success' : 'gray')
                    // URL to the QR code image if assigned, otherwise '#' (disabled link).
                    ->url(fn($record) => $record->qrLink ? asset('storage/' . $record->qrLink->qr_path) : '#')
                    ->openUrlInNewTab() // Opens the QR code image in a new tab.
                    ->visible(fn($record) => $record->qrLink), // Only visible if a QR code is assigned.

                // Action to generate a sticker for the business.
                Tables\Actions\Action::make('generate_sticker')
                    ->label('Sticker') // Button label
                    ->icon('heroicon-o-tag') // Tag icon
                    // Calls the generate method on StickerController with the current record.
                    ->action(fn($record) => app(StickerController::class)->generate($record))
                    ->color('primary') // Primary color
                    // Only visible if the business has a unique_code (required for sticker generation).
                    ->visible(fn($record) => !empty($record->unique_code)),

                // Group of additional actions, shown in a dropdown.
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(), // Standard view action

                    // Action to export a single business record to PDF.
                    Action::make('export_single_pdf')
                        ->label('Export PDF') // Button label
                        ->icon('heroicon-o-document-arrow-down') // Download icon
                        ->color('danger') // Danger color
                        // URL to the single PDF export route.
                        ->url(fn($record) => route('export-business.pdf.single', $record->id))
                        ->openUrlInNewTab(), // Opens in a new tab

                    Tables\Actions\DeleteAction::make(), // Standard delete action
                    Tables\Actions\RestoreAction::make(), // Standard restore action for soft deletes
                    Tables\Actions\ForceDeleteAction::make(), // Standard force delete action
                ])
                    ->label('More') // Label for the dropdown button
                    ->icon('heroicon-m-ellipsis-vertical') // Vertical ellipsis icon
                    ->size('sm') // Small size button
                    ->color('gray'), // Gray color for the dropdown button
            ])
            ->bulkActions([
                // Group of bulk actions applied to selected records.
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Bulk delete

                    // Bulk action to export selected businesses to a single PDF.
                    Tables\Actions\BulkAction::make('export_pdf')
                        ->label('Export Selected PDF') // Label for the action
                        ->icon('heroicon-o-document-arrow-down') // Download icon
                        ->color('danger') // Danger color
                        // Action to generate and download the PDF.
                        ->action(function (\Illuminate\Support\Collection $records) {
                            // Load necessary relationships for the PDF export.
                            $businesses = $records->load(['type', 'qrLink', 'galleries', 'products']);
                            // Generate PDF using DomPDF facade.
                            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.businesses-pdf', [
                                'businesses' => $businesses,
                            ])->setPaper('a4', 'landscape'); // Set paper size and orientation.

                            // Stream the PDF as a download response.
                            return response()->streamDownload(
                                fn() => print($pdf->output()),
                                'selected-businesses-' . now()->format('Y-m-d') . '.pdf' // File name
                            );
                        }),

                    // Bulk action to assign QR codes to multiple selected businesses.
                    Tables\Actions\BulkAction::make('bulk_assign_qr')
                        ->label('Assign QR Codes') // Label for the action
                        ->icon('heroicon-o-qr-code') // QR code icon
                        ->color('info') // Information color
                        ->form([
                            // Select dropdown to choose a QR Code Template.
                            Select::make('qr_link_id')
                                ->label('QR Code Template') // Label for the dropdown
                                ->relationship('qrLink', 'name') // Relationship to QR link model, showing 'name'.
                                ->required(), // This field is required.
                        ])
                        // Action to update the 'qr_link_id' for each selected record.
                        ->action(function (array $data, \Illuminate\Support\Collection $records) {
                            // Iterate over each selected business record.
                            $records->each(function ($record) use ($data) {
                                // Update the 'qr_link_id' for the current record.
                                $record->update(['qr_link_id' => $data['qr_link_id']]);
                            });

                            // Send a success notification to the user.
                            Notification::make()
                                ->title('QR Codes assigned successfully')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->recordUrl(null) // Disables clickable rows (no navigation when clicking a row).
            ->striped() // Adds alternating row colors for better readability.
            ->paginated([10, 25, 50, 100]); // Pagination options for records per page.
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
