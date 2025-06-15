<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages; // Imports specific page classes for the Gallery resource.
use App\Models\Gallery; // Imports the Eloquent model this resource manages.
use Filament\Forms; // Namespace for Filament Form components.
use Filament\Forms\Form; // Class for defining a Filament Form.
use Filament\Resources\Resource; // Base class for Filament Resources.
use Filament\Tables; // Namespace for Filament Table components.
use Filament\Tables\Table; // Class for defining a Filament Table.
use Filament\Tables\Filters\TrashedFilter; // Table filter to show soft-deleted records.

/**
 * Class GalleryResource
 *
 * This Filament Resource defines the administrative interface for the `Gallery` model.
 * It provides a comprehensive set of features for managing gallery items, including:
 * - Defining forms for creating and editing gallery entries.
 * - Configuring tables for listing and filtering gallery items.
 * - Setting up individual row actions and bulk actions.
 * - Organizing the resource within the Filament navigation.
 */
class GalleryResource extends Resource
{
    // Define the Eloquent model that this resource manages.
    protected static ?string $model = Gallery::class;

    // Specifies the navigation group under which this resource will be listed in the Filament sidebar.
    protected static ?string $navigationGroup = 'Default Website';

    // Sets the sorting order for this resource within its navigation group (lower numbers appear higher).
    protected static ?int $navigationSort = 1;

    // Define the icon that will appear in the Filament navigation sidebar for this resource.
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating and editing Gallery records.
     *
     * This method configures all the input fields that users will interact with
     * when adding a new gallery item or modifying an existing one.
     *
     * @param Form $form The Filament Form instance.
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Text input field for the title of the gallery image.
                Forms\Components\TextInput::make('title')
                    ->label('Title Image') // User-friendly label displayed in the form.
                    ->required() // Marks this field as mandatory for submission.
                    ->maxLength(255), // Sets the maximum character limit for the input.

                // File upload component for the actual gallery image.
                Forms\Components\FileUpload::make('image')
                    ->label('Image Gallery') // User-friendly label.
                    ->directory('gallery') // Specifies the subdirectory within the default disk (usually 'storage/app/public') where images will be stored.
                    ->image() // Enforces that the uploaded file must be an image.
                    // Defines an array of accepted MIME types for client-side validation, ensuring only specified image formats are uploaded.
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg'])
                    ->required(), // Marks this field as mandatory.
            ]);
    }

    /**
     * Define the table schema for displaying Gallery records in the Filament admin panel.
     *
     * This method configures the columns that will be displayed in the table,
     * as well as filters, actions for individual rows, and bulk actions for multiple rows.
     *
     * @param Table $table The Filament Table instance.
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Displays the title of the gallery item.
                Tables\Columns\TextColumn::make('title')
                    ->label('Title Image') // User-friendly label for the column header.
                    ->sortable() // Allows users to sort table data by this column.
                    ->searchable(), // Enables searching records by matching against this column's content.

                // Displays the gallery image.
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image Gallery'), // User-friendly label.
            ])
            ->filters([
                // Allows filtering records based on their soft-deleted status.
                // Options include showing all records, records with trashed items, or only trashed items.
                TrashedFilter::make(),
            ])
            ->actions([
                // Action to view the full details of a single gallery record.
                Tables\Actions\ViewAction::make(),
                // Action to soft delete a single gallery record. Requires the SoftDeletes trait on the model.
                Tables\Actions\DeleteAction::make(),
                // Action to open the edit form for a single gallery record.
                Tables\Actions\EditAction::make(),
                // Action to restore a soft-deleted gallery record. This button appears only for trashed records.
                Tables\Actions\RestoreAction::make(),
                // Action to permanently delete a soft-deleted gallery record. This button appears only for trashed records.
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                // Groups multiple bulk actions under a single dropdown menu, applied to selected records.
                Tables\Actions\BulkActionGroup::make([
                    // Bulk action to soft delete multiple selected gallery records.
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk action to restore multiple soft-deleted gallery records.
                    Tables\Actions\RestoreBulkAction::make(),
                    // Bulk action to permanently delete multiple soft-deleted gallery records.
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Define the relation managers that can be attached to this resource.
     *
     * Relation managers allow managing related models directly from a resource's view/edit pages.
     * For example, if a Gallery could have 'comments', a CommentRelationManager would be listed here.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // Currently, no relation managers are defined for the Gallery resource.
        ];
    }

    /**
     * Define the pages associated with this resource.
     *
     * Pages define the routes and components for different views of the resource
     * within the Filament admin panel (e.g., listing all records, creating a new one, editing one).
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),    // The main listing page for all gallery items.
            'create' => Pages\CreateGallery::route('/create'), // The page for creating a new gallery item.
            'edit' => Pages\EditGallery::route('/{record}/edit'), // The page for editing an existing gallery item, identified by its record ID.
        ];
    }
}
