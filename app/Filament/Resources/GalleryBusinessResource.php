<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryBusinessResource\Pages;
use App\Filament\Resources\GalleryBusinessResource\RelationManagers;
use App\Models\GalleryBusiness; // The Eloquent model for individual gallery items
use App\Models\Business; // Assuming you have a Business model for linking images
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope; // Used if your model supports soft deletes
use Filament\Forms\Components\Section; // For organizing form fields into visual sections
use Filament\Forms\Components\Group; // For grouping form fields horizontally
use Filament\Tables\Columns\TextColumn; // For displaying text in table columns
use Filament\Tables\Columns\ImageColumn; // For displaying images in table columns
use Filament\Tables\Columns\BadgeColumn; // For displaying data as a badge
use Filament\Tables\Filters\SelectFilter; // For filtering based on a selection
use Filament\Tables\Filters\TrashedFilter; // For filtering soft-deleted records
use Carbon\Carbon; // Laravel's date and time library for formatting
use Illuminate\Database\Eloquent\Model; // Base Eloquent Model class

// Import classes needed for ZIP file creation and streaming
use ZipArchive; // PHP's built-in class for creating and extracting ZIP archives
use Illuminate\Support\Facades\Storage; // Laravel's file storage facade
use Symfony\Component\HttpFoundation\StreamedResponse; // For efficient downloading of large files

// This class defines the Filament resource for managing 'GalleryBusiness' records.
// It controls the forms for creating/editing, and the table for listing business gallery images.
class GalleryBusinessResource extends Resource
{
    // Specifies the Eloquent model associated with this Filament resource.
    protected static ?string $model = GalleryBusiness::class;

    /**
     * Retrieves the navigation badge for the resource.
     * This method displays the total count of business gallery items next to the navigation item.
     */
    public static function getNavigationBadge(): ?string
    {
        return GalleryBusiness::count();
    }

    // Organizes the resource within the Filament navigation sidebar under the 'Business Operations' group.
    protected static ?string $navigationGroup = 'Business Operations';
    // Sets the sort order of the resource in the navigation group (lower numbers appear higher).
    // This resource will appear after 'EventsResource' (if sort 1) or 'FoodCategoryResource' (if sort 2 is also used there).
    protected static ?int $navigationSort = 2;
    // Specifies the Heroicon icon to be displayed next to the resource in the navigation.
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    // Sets the label displayed in the Filament sidebar navigation for this resource.
    protected static ?string $navigationLabel = 'Business Gallery';
    // Sets the singular label used throughout the Filament panel for a single record.
    protected static ?string $modelLabel = 'Gallery Item';
    // Sets the plural label used throughout the Filament panel for multiple records.
    protected static ?string $pluralModelLabel = 'Business Gallery';

    /**
     * Defines the form schema for creating and editing business gallery items.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Defines a section within the form for 'Gallery Information'.
                Section::make('Gallery Information')
                    ->description('Add images to showcase your business') // A helpful description for the section.
                    ->icon('heroicon-m-camera') // Icon displayed next to the section title.
                    ->schema([
                        // Groups fields horizontally within this section.
                        Group::make()
                            ->schema([
                                // Select field to link a gallery item to a specific business.
                                Forms\Components\Select::make('business_id')
                                    ->label('Business') // Label displayed to the user.
                                    ->placeholder('Select a business') // Placeholder text.
                                    // Defines a relationship field: fetches business names from the 'business' relationship
                                    // and uses 'name' as the display value, 'id' as the stored value.
                                    ->relationship('business', 'name')
                                    // If no relationship, you would manually provide options like:
                                    // ->options(Business::pluck('name', 'id'))
                                    ->searchable() // Allows searching within the dropdown.
                                    ->preload() // Preloads all options, useful for smaller datasets.
                                    ->required() // Makes the field mandatory.
                                    ->live() // Makes the field 'live' for real-time interaction (though not directly used here for updates).
                                    ->helperText('Choose the business this gallery item belongs to') // Small helper text.
                                    // Allows users to create a new 'Business' record directly from this select field's dropdown.
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        // Add other business fields here if needed when creating a new business from this form.
                                    ])
                                    ->columnSpan(2), // Makes this field span 2 columns in its parent group.

                                // Text input field for the image title.
                                Forms\Components\TextInput::make('title')
                                    ->label('Image Title') // Label displayed to the user.
                                    ->placeholder('Enter a descriptive title for the image') // Placeholder text.
                                    ->required() // Makes the field mandatory.
                                    ->maxLength(255) // Maximum character limit.
                                    ->live(onBlur: true) // Makes the field 'live' when focus leaves the input.
                                    ->helperText('This title will be displayed with the image') // Small helper text.
                                    ->columnSpan(2), // Makes this field span 2 columns in its parent group.
                            ])
                            ->columns(4), // Arranges fields within this group into 4 columns.
                    ]),

                // Defines a section for image upload functionality.
                Section::make('Image Upload')
                    ->description('Upload high-quality images to showcase your business') // Helpful description.
                    ->icon('heroicon-m-photo') // Icon for the section.
                    ->schema([
                        // File upload field for the gallery image.
                        Forms\Components\FileUpload::make('image')
                            ->label('Gallery Image') // Label for the upload field.
                            ->directory('gallery_business') // Stores uploaded images in 'storage/app/public/gallery_business'.
                            ->image() // Validates that the uploaded file is an image.
                            ->imageEditor() // Enables Filament's built-in image editor (crop, resize, rotate).
                            ->imageEditorAspectRatios([ // Defines pre-set aspect ratios for the image editor.
                                '16:9',
                                '4:3',
                                '3:4',
                                '1:1',
                            ])
                            ->imageCropAspectRatio('16:9') // Sets a default crop aspect ratio for the editor.
                            ->imageResizeTargetWidth('1920') // Resizes uploaded images to this width.
                            ->imageResizeTargetHeight('1080') // Resizes uploaded images to this height.
                            // Defines allowed file types.
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                            ->maxSize(5120) // Maximum file size allowed in KB (5MB).
                            ->required() // Makes the image upload mandatory.
                            ->helperText('Recommended: 1920x1080px (16:9 ratio) • Max size: 5MB • Formats: JPG, PNG, GIF, WebP') // Guidance for user.
                            ->columnSpanFull() // Makes the upload field span the full width.
                            ->imagePreviewHeight('200') // Sets the height of the image preview in the form.
                            ->loadingIndicatorPosition('center') // Position of loading spinner during upload.
                            ->panelAspectRatio('16:9') // Aspect ratio of the upload panel.
                            ->panelLayout('integrated') // Layout style of the upload panel.
                            ->removeUploadedFileButtonPosition('top-right') // Position of the remove button for uploaded files.
                            ->uploadButtonPosition('center') // Position of the upload button.
                            ->uploadProgressIndicatorPosition('center'), // Position of the upload progress bar.
                    ])
            ]);
    }

    /**
     * Defines the table schema for listing business gallery items.
     * It includes columns for display, search, sorting, filtering, and actions.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column for displaying the gallery image itself.
                ImageColumn::make('image')
                    ->label('Image') // Label for the column.
                    ->height(80) // Height of the displayed image in the table.
                    ->width(120) // Width of the displayed image.
                    ->extraImgAttributes(['class' => 'rounded-lg object-cover']) // Adds custom CSS classes for styling.
                    ->checkFileExistence(false), // Skips checking if the file exists, useful for performance or external storage.

                // Column for displaying the image title.
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable() // Allows searching by image title.
                    ->sortable() // Allows sorting by image title.
                    ->weight('bold') // Makes the text bold.
                    ->icon('heroicon-m-photo') // Displays a photo icon next to the title.
                    ->description( // Adds a smaller, secondary line of text below the title.
                        fn(GalleryBusiness $record): ?string =>
                        // Displays the creation date in the description.
                        'Added: ' . ($record->created_at ? $record->created_at->format('M d, Y') : 'N/A')
                    ),

                // Column for displaying the linked business's name.
                TextColumn::make('business.name') // Accesses the 'name' attribute through the 'business' relationship.
                    ->label('Business') // Label for the column.
                    ->searchable() // Allows searching by business name.
                    ->sortable() // Allows sorting by business name.
                    ->badge() // Displays the business name as a Filament badge.
                    ->color('primary') // Sets the badge color.
                    ->icon('heroicon-m-building-office') // Displays a building icon.
                    // Generates a URL to edit the associated business record, allowing direct navigation.
                    ->url(
                        fn(GalleryBusiness $record): ?string =>
                        $record->business ? route('filament.admin.resources.businesses.edit', $record->business) : null
                    )
                    ->openUrlInNewTab() // Opens the business edit page in a new browser tab.
                    ->tooltip('Click to view business details'), // Tooltip on hover.

                // Column to display the file size of the image.
                TextColumn::make('image_size')
                    ->label('File Size')
                    // Custom state retrieval: calculates file size in human-readable format (KB, MB).
                    ->getStateUsing(function ($record): ?string {
                        if (!$record->image) return null; // If no image, return null.

                        $path = storage_path('app/public/' . $record->image); // Get full path to the image.
                        if (file_exists($path)) { // Check if the file actually exists.
                            $bytes = filesize($path); // Get file size in bytes.
                            $units = ['B', 'KB', 'MB', 'GB']; // Units for conversion.
                            // Convert bytes to appropriate unit.
                            for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                                $bytes /= 1024;
                            }
                            return round($bytes, 2) . ' ' . $units[$i]; // Return formatted size.
                        }
                        return null; // Return null if file not found.
                    })
                    ->badge() // Displays the size as a badge.
                    ->color('gray') // Gray color for the badge.
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default.

                // Column for displaying the creation timestamp.
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i') // Formats the date and time.
                    ->sortable() // Allows sorting.
                    ->since() // Displays time elapsed since creation (e.g., '2 days ago').
                    ->tooltip( // Shows a detailed timestamp on hover.
                        fn(GalleryBusiness $record): string =>
                        'Created: ' . $record->created_at->format('F j, Y \a\t g:i A')
                    )
                    ->toggleable(), // Can be toggled visible/hidden by user.

                // Column for displaying the last update timestamp.
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->since() // Displays time elapsed since last update.
                    ->tooltip( // Shows a detailed timestamp on hover.
                        fn(GalleryBusiness $record): string =>
                        'Updated: ' . $record->updated_at->format('F j, Y \a\t g:i A')
                    )
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default.
            ])
            ->filters([
                // Filter to select gallery items by associated business.
                SelectFilter::make('business_id')
                    ->label('Business')
                    ->relationship('business', 'name') // Uses the 'business' relationship for options.
                    ->searchable() // Allows searching within the filter dropdown.
                    ->preload() // Preloads all business options.
                    ->multiple(), // Allows selecting multiple businesses for filtering.

                // Toggle filter for items that have an image uploaded.
                Tables\Filters\Filter::make('has_image')
                    ->label('Has Image')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('image')) // Filters for records where 'image' column is not null.
                    ->toggle(), // Displays as a toggle switch.

                // Filter for 'Created Date' range.
                Tables\Filters\Filter::make('created_at')
                    ->label('Created Date')
                    ->form([ // Defines the form fields for the filter.
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created from')
                            ->native(false), // Force Filament's custom date picker, not browser's native.
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created until')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder { // Custom query logic for filtering.
                        return $query
                            ->when(
                                $data['created_from'], // If 'created_from' date is provided.
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date), // Filter records created on or after that date.
                            )
                            ->when(
                                $data['created_until'], // If 'created_until' date is provided.
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date), // Filter records created on or before that date.
                            );
                    })
                    ->indicateUsing(function (array $data): array { // Displays active filter indicators above the table.
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
                // TrashedFilter::make(), // Uncomment this line if your GalleryBusiness model uses Laravel's SoftDeletes trait.
            ])
            ->filtersFormColumns(2) // Arranges the filter form fields into 2 columns.
            ->actions([
                // Groups common actions under a single button (ellipsis icon).
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info')
                        ->modalHeading('Gallery Item Details') // Custom heading for the view modal.
                        ->modalSubmitAction(false) // Hides the submit button in the view modal.
                        ->modalCancelActionLabel('Close'), // Custom label for the close button.

                    Tables\Actions\EditAction::make()
                        ->color('warning'),

                    // Custom action to preview the uploaded image in a new tab.
                    Tables\Actions\Action::make('preview')
                        ->label('Preview Image')
                        ->icon('heroicon-m-magnifying-glass-plus')
                        ->color('success')
                        ->action(function ($record) {
                            // This action redirects to the image URL, effectively opening it.
                            if ($record->image) {
                                return redirect()->to(asset('storage/' . $record->image));
                            }
                        })
                        ->openUrlInNewTab() // Ensures the link opens in a new browser tab.
                        ->url(fn($record) => $record->image ? asset('storage/' . $record->image) : null), // Dynamically sets the URL.

                    Tables\Actions\DeleteAction::make()
                        ->color('danger'),
                ])
                    ->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->button(), // Renders the group as a button.
            ])
            ->bulkActions([
                // Groups common bulk actions for selected records.
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Bulk delete (soft delete if enabled, otherwise permanent).

                    // Custom bulk action to download selected images as a ZIP file.
                    Tables\Actions\BulkAction::make('download_images')
                        ->label('Download Images')
                        ->icon('heroicon-m-arrow-down-tray') // Download icon.
                        ->action(function ($records) { // Defines the action logic.
                            // Filter records to only include those with an image path.
                            $images = $records->whereNotNull('image');

                            // If no images are selected or available, send a notification and exit.
                            if ($images->isEmpty()) {
                                \Filament\Notifications\Notification::make()
                                    ->title('No images to download')
                                    ->warning()
                                    ->send();
                                return;
                            }

                            // Generate a unique ZIP file name based on current timestamp.
                            $zipFileName = 'gallery_images_' . now()->format('Ymd_His') . '.zip';
                            // Define a temporary path to store the ZIP file.
                            $tempZipPath = storage_path('app/public/' . $zipFileName);

                            // Initialize ZipArchive object.
                            $zip = new ZipArchive;

                            // Attempt to open (or create) the ZIP file for writing.
                            if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                                // Loop through each image record to add its file to the ZIP archive.
                                foreach ($images as $image) {
                                    // Get the full file path from storage.
                                    $filePath = Storage::disk('public')->path($image->image);
                                    $fileName = basename($image->image); // Get just the filename for within the ZIP.

                                    // Check if the actual file exists before adding.
                                    if (file_exists($filePath)) {
                                        $zip->addFile($filePath, $fileName); // Add the file to the ZIP.
                                    } else {
                                        // Optional: Send a warning notification if an image file is missing.
                                        \Filament\Notifications\Notification::make()
                                            ->title('Warning: Image not found')
                                            ->body("Image '{$fileName}' could not be found and was skipped from the download.")
                                            ->warning()
                                            ->send();
                                    }
                                }

                                $zip->close(); // Close the ZIP archive, saving changes.

                                // Send a success notification to the user.
                                \Filament\Notifications\Notification::make()
                                    ->title('Download started')
                                    ->body($images->count() . ' images are being prepared for download.')
                                    ->success()
                                    ->send();

                                // Return a StreamedResponse to efficiently download the large ZIP file.
                                return response()->streamDownload(function () use ($tempZipPath) {
                                    // Read the file in chunks to avoid memory issues for large files.
                                    echo Storage::disk('public')->get(basename($tempZipPath));
                                    // Delete the temporary ZIP file after it's streamed.
                                    unlink($tempZipPath);
                                }, $zipFileName, [
                                    'Content-Type' => 'application/zip', // Set MIME type for ZIP.
                                    'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"', // Forces download with the specified filename.
                                ]);

                                // Alternative for smaller files (less memory efficient for large files):
                                // return Storage::disk('public')->download($zipFileName);

                            } else {
                                // If ZIP archive creation failed, send an error notification.
                                \Filament\Notifications\Notification::make()
                                    ->title('Error creating ZIP file')
                                    ->body('Could not create the ZIP archive. Please check permissions.')
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->requiresConfirmation() // Asks for confirmation before executing the action.
                        ->color('success'), // Green color for the button.
                ]),
            ])
            ->defaultSort('created_at', 'desc') // Default sorting: newest gallery items first.
            ->striped() // Adds alternating row colors for better readability.
            ->persistSortInSession() // Remembers user's sorting preference across sessions.
            ->persistSearchInSession() // Remembers user's search query across sessions.
            ->persistFiltersInSession() // Remembers user's active filters across sessions.
            // Custom messages and icon for when no gallery items are found in the table.
            ->emptyStateHeading('No gallery items found')
            ->emptyStateDescription('Start building your business gallery by adding your first image.')
            ->emptyStateIcon('heroicon-o-photo')
            ->emptyStateActions([
                // Action button in the empty state message to create a new gallery item.
                Tables\Actions\CreateAction::make()
                    ->label('Add First Gallery Item'),
            ]);
    }

    /**
     * Defines any relationships that should be managed directly from this resource using Relation Managers.
     */
    public static function getRelations(): array
    {
        return [
            // Add relation managers here if needed, e.g., to manage 'Comments' related to a gallery item.
            // RelationManagers\CommentsRelationManager::class,
        ];
    }

    /**
     * Defines the pages associated with this resource.
     * These are the different views for interacting with gallery item records (list, create, view, edit).
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryBusinesses::route('/'), // Lists all business gallery items.
            'create' => Pages\CreateGalleryBusiness::route('/create'), // Form to create a new gallery item.
            'view' => Pages\ViewGalleryBusiness::route('/{record}'), // Displays details of a specific gallery item.
            'edit' => Pages\EditGalleryBusiness::route('/{record}/edit'), // Form to edit a specific gallery item.
        ];
    }

    /**
     * Modifies the Eloquent query used for global search.
     * This ensures that when searching globally, related 'business' data is eagerly loaded.
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        // Adds a 'with' clause to eager load the 'business' relationship.
        // This is important because we want to search on 'business.name'.
        return parent::getGlobalSearchEloquentQuery()->with(['business']);
    }

    /**
     * Defines which attributes (database columns) should be searchable in the global search bar.
     * Searches will be performed on the 'title' of the gallery item and the 'name' of the associated business.
     */
    public static function getGlobalSearchAttributes(): array
    {
        return ['title', 'business.name'];
    }
}
