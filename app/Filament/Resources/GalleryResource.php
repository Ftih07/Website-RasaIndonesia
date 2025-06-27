<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages; // Imports the 'Pages' namespace for this resource
use App\Models\Gallery; // Imports the Eloquent model this resource manages
use Filament\Forms; // Namespace for Filament Form components
use Filament\Forms\Form; // Class for defining form schemas
use Filament\Resources\Resource; // Base class for Filament Resources
use Filament\Tables; // Namespace for Filament Table components
use Filament\Tables\Table; // Class for defining table schemas
use Filament\Tables\Filters\TrashedFilter; // Imports the filter for soft-deleted records
use Filament\Support\Enums\FontWeight; // Imports enum for font weight styling in tables

/**
 * Class GalleryResource
 *
 * This Filament Resource is designed for managing 'Gallery' items within the admin panel.
 * It provides a user-friendly interface for CRUD (Create, Read, Update, Delete) operations
 * on gallery images, including features like image uploads with editing, sortable and searchable
 * tables, and soft-delete capabilities.
 */
class GalleryResource extends Resource
{
    // Defines the Eloquent model that this Filament resource manages.
    // All operations (create, read, update, delete) will be performed on this model.
    protected static ?string $model = Gallery::class;

    /**
     * Retrieves the count of all gallery items to display as a badge in the navigation.
     * This provides a quick overview of the total number of entries.
     */
    public static function getNavigationBadge(): ?string
    {
        return Gallery::count();
    }

    // Defines the navigation group under which this resource will appear in the sidebar.
    // This helps organize resources into logical categories.
    protected static ?string $navigationGroup = 'Content Management';

    // Sets the sorting order for this resource within its navigation group.
    // Lower numbers appear higher in the list.
    protected static ?int $navigationSort = 1;

    // Specifies the Heroicon to be used as the icon for this resource in the navigation.
    // 'heroicon-o-photo' is an outline photo icon.
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    // Sets the label displayed in the Filament navigation sidebar for this resource.
    protected static ?string $navigationLabel = 'Gallery';

    // Sets the singular label for the model, used in various parts of the UI (e.g., "New Gallery Item").
    protected static ?string $modelLabel = 'Gallery Item';

    // Sets the plural label for the model, used in table headings and other areas (e.g., "Listing Gallery Items").
    protected static ?string $pluralModelLabel = 'Gallery Items';

    /**
     * Defines the form schema for creating and editing Gallery items.
     * It uses Filament's form components to build the input fields.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content area for form fields, spanning 2 columns on large screens.
                Forms\Components\Card::make() // Using Card to group form fields nicely visually.
                    ->schema([
                        // Section for basic gallery item information.
                        Forms\Components\Section::make('Gallery Information')
                            ->description('Basic information about the gallery item') // Helper text for the section.
                            ->icon('heroicon-m-information-circle') // Icon for the section header.
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Image Title') // User-friendly label for the input.
                                    ->placeholder('Enter a descriptive title for this image') // Placeholder text.
                                    ->required() // Makes the field mandatory.
                                    ->maxLength(255) // Sets maximum character length.
                                    ->live(onBlur: true) // Updates other fields or reactive components when input blurs.
                                    ->columnSpanFull(), // Makes the input span the full width of its parent columns.
                            ]),

                        // Section for image upload functionality.
                        Forms\Components\Section::make('Image Upload')
                            ->description('Upload the gallery image (JPEG, PNG, GIF, SVG supported)')
                            ->icon('heroicon-m-photo') // Icon for the section header.
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Gallery Image') // Label for the file upload field.
                                    ->directory('gallery') // Specifies the storage disk subdirectory where files will be saved.
                                    ->image() // Ensures only image files can be uploaded.
                                    ->imageEditor() // Enables Filament's built-in image editor (crop, resize).
                                    ->imageEditorAspectRatios([ // Defines aspect ratios available in the image editor.
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml']) // Allowed file types.
                                    ->maxSize(5120) // Sets a maximum file size limit (5120 KB = 5MB).
                                    ->required() // Makes the image upload mandatory.
                                    ->columnSpanFull() // Makes the uploader span the full width.
                                    ->helperText('Maximum file size: 5MB. Recommended dimensions: 1920x1080px for best quality.') // Helpful tips for the user.
                                    ->imagePreviewHeight('250') // Sets the height of the image preview.
                                    ->loadingIndicatorPosition('left') // Positions the loading indicator.
                                    ->panelAspectRatio('2:1') // Sets the aspect ratio of the upload panel.
                                    ->panelLayout('integrated') // Sets the layout of the upload panel.
                                    ->removeUploadedFileButtonPosition('right') // Positions the remove button.
                                    ->uploadButtonPosition('left') // Positions the upload button.
                                    ->uploadProgressIndicatorPosition('left'), // Positions the upload progress indicator.
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]), // This card takes 2 columns on large screens.

                // Optional sidebar for meta-information (like timestamps), spanning 1 column on large screens.
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at') // Displays creation timestamp.
                            ->label('Created at')
                            ->content(fn(Gallery $record): ?string => $record?->created_at?->diffForHumans()) // Displays time since creation (e.g., "3 hours ago").
                            ->hidden(fn(?Gallery $record) => $record === null), // Hides if creating a new record.

                        Forms\Components\Placeholder::make('updated_at') // Displays last updated timestamp.
                            ->label('Last modified at')
                            ->content(fn(Gallery $record): ?string => $record?->updated_at?->diffForHumans()) // Displays time since last update.
                            ->hidden(fn(?Gallery $record) => $record === null), // Hides if creating a new record.
                    ])
                    ->columnSpan(['lg' => 1]) // This card takes 1 column on large screens.
                    ->hidden(fn(?Gallery $record) => $record === null), // Hides the whole card if creating a new record.
            ])
            ->columns([ // Defines the number of columns for the form layout.
                'sm' => 3, // 3 columns on small screens and up.
                'lg' => null, // Resets column layout on large screens, allowing cards to control their spans.
            ]);
    }

    /**
     * Defines the table schema for listing Gallery items.
     * It uses Filament's table components to build the columns, filters, and actions.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Preview') // Label for the column.
                    ->height(80) // Sets the height of the displayed image in the table row.
                    ->width(120) // Sets the width of the displayed image.
                    ->extraImgAttributes(['class' => 'rounded-lg object-cover']) // Adds custom CSS classes for visual styling (rounded corners, cover fit).
                    ->checkFileExistence(false), // Skips checking if the image file physically exists, improving performance for external storage or missing files.

                Tables\Columns\TextColumn::make('title')
                    ->label('Title') // Label for the column.
                    ->searchable() // Allows searching by this column's content.
                    ->sortable() // Allows sorting the table by this column.
                    ->weight(FontWeight::Medium) // Sets the font weight to medium using Filament's enum.
                    ->description(fn(Gallery $record): string => 'ID: ' . $record->id) // Adds a small description under the title, showing the record's ID.
                    ->wrap(), // Wraps text if it's too long to fit in one line.

                // Custom column to display the file size of the image.
                Tables\Columns\TextColumn::make('image_size')
                    ->label('File Size')
                    // Custom state retrieval logic to calculate and format file size.
                    ->getStateUsing(function ($record): ?string {
                        if (!$record->image) return null; // If no image path is stored, return null.

                        // Construct the full path to the image file on the local disk.
                        $path = storage_path('app/public/' . $record->image);
                        if (file_exists($path)) { // Check if the file physically exists.
                            $bytes = filesize($path); // Get file size in bytes.
                            $units = ['B', 'KB', 'MB', 'GB']; // Units for conversion.
                            // Loop to convert bytes to the most appropriate human-readable unit.
                            for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                                $bytes /= 1024;
                            }
                            return round($bytes, 2) . ' ' . $units[$i]; // Return formatted size (e.g., "1.23 MB").
                        }
                        return null; // Return null if file not found.
                    })
                    ->badge() // Displays the size as a visually distinct badge.
                    ->color('gray') // Sets the badge color to gray.
                    ->toggleable(isToggledHiddenByDefault: true), // Allows users to show/hide this column; hidden by default.

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created') // Label for the column.
                    ->dateTime('M j, Y') // Formats the datetime (e.g., "Jan 15, 2023").
                    ->sortable() // Allows sorting.
                    ->toggleable() // Allows showing/hiding.
                    ->since() // Displays time difference (e.g., "2 days ago").
                    ->tooltip(fn(Gallery $record): string => $record->created_at->format('F j, Y \a\t g:i A')), // Shows full date/time on hover.

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated') // Label for the column.
                    ->dateTime('M j, Y') // Formats the datetime.
                    ->sortable() // Allows sorting.
                    ->toggleable(isToggledHiddenByDefault: true) // Hidden by default.
                    ->since(), // Displays time difference.

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Deleted') // Label for the column (for soft-deleted items).
                    ->dateTime('M j, Y') // Formats the datetime.
                    ->sortable() // Allows sorting.
                    ->toggleable(isToggledHiddenByDefault: true) // Hidden by default.
                    ->placeholder('—') // Displays a dash if the record is not deleted.
                    ->since(), // Displays time difference if deleted.
            ])
            ->filters([
                TrashedFilter::make(), // Provides a filter to show only soft-deleted records or all records.

                Tables\Filters\Filter::make('recent')
                    ->label('Recent (Last 7 days)') // Label for the custom filter.
                    ->query(fn($query) => $query->where('created_at', '>=', now()->subDays(7))) // Defines the query logic: show items created in the last 7 days.
                    ->indicator('Recent'), // Text to display as an active filter indicator.
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View') // Label for the action button.
                    ->icon('heroicon-m-eye'), // Icon for the action button.

                Tables\Actions\EditAction::make()
                    ->label('Edit') // Label for the action button.
                    ->icon('heroicon-m-pencil-square'), // Icon for the action button.

                Tables\Actions\DeleteAction::make()
                    ->label('Delete') // Label for the action button (soft deletes by default if `SoftDeletes` trait is used).
                    ->icon('heroicon-m-trash'), // Icon for the action button.

                Tables\Actions\RestoreAction::make() // Action to restore soft-deleted records.
                    ->label('Restore')
                    ->icon('heroicon-m-arrow-path'),

                Tables\Actions\ForceDeleteAction::make() // Action to permanently delete records.
                    ->label('Force Delete')
                    ->icon('heroicon-m-x-mark'),
            ])
            ->bulkActions([ // Actions that can be performed on multiple selected records.
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Bulk soft-delete.
                    Tables\Actions\RestoreBulkAction::make(), // Bulk restore.
                    Tables\Actions\ForceDeleteBulkAction::make(), // Bulk force delete.
                ]),
            ])
            ->defaultSort('created_at', 'desc') // Sets the default sorting order for the table (by creation date, descending).
            ->poll('30s') // Automatically refreshes the table data every 30 seconds.
            ->deferLoading() // Defers loading table data until filters/search are applied or pagination changes. Improves initial load time.
            ->striped() // Adds zebra stripping (alternating row colors) to the table for better readability.
            ->paginated([25, 50, 100, 'all']) // Defines pagination options (items per page).
            ->extremePaginationLinks() // Shows first/last page links in pagination.
            ->emptyStateActions([ // Actions displayed when the table is empty.
                Tables\Actions\CreateAction::make()
                    ->label('Create your first gallery item')
                    ->icon('heroicon-m-plus'),
            ])
            ->emptyStateHeading('No gallery items yet') // Heading displayed when the table is empty.
            ->emptyStateDescription('Once you add gallery items, they will appear here.') // Description for empty state.
            ->emptyStateIcon('heroicon-o-photo'); // Icon for empty state.
    }

    /**
     * Defines any relationships that should be displayed or managed directly within this resource.
     * Currently, no relationships are directly managed here, but this is where they would be defined.
     */
    public static function getRelations(): array
    {
        return [
            // Example: If Gallery had 'comments', you could add CommentRelationManager::class here.
        ];
    }

    /**
     * Defines the pages associated with this resource and their routes.
     * This maps standard CRUD operations to their respective Filament pages.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'), // Route for listing all gallery items.
            'create' => Pages\CreateGallery::route('/create'), // Route for creating a new gallery item.
            'edit' => Pages\EditGallery::route('/{record}/edit'), // Route for editing an existing gallery item.
            'view' => Pages\ViewGallery::route('/{record}'), // Route for viewing an existing gallery item's details.
        ];
    }
}
