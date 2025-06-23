<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QnAResource\Pages; // Imports specific page classes for the QnA resource.
use App\Models\QnA; // Imports the Eloquent model this resource manages.
use Filament\Forms; // Namespace for Filament Form components.
use Filament\Forms\Form; // Class for defining a Filament Form.
use Filament\Resources\Resource; // Base class for Filament Resources.
use Filament\Tables; // Namespace for Filament Table components.
use Filament\Tables\Table; // Class for defining a Filament Table.
use Filament\Tables\Filters\TrashedFilter; // Table filter to show soft-deleted records.

/**
 * Class QnAResource
 *
 * This Filament Resource defines the administrative interface for the `QnA` model.
 * It provides a comprehensive set of features for managing Question & Answer entries, including:
 * - Defining forms for creating and editing QnA items.
 * - Configuring tables for listing and filtering QnA entries.
 * - Setting up individual row actions and bulk actions.
 * - Organizing the resource within the Filament navigation.
 */
class QnAResource extends Resource
{
    // Define the Eloquent model that this resource manages.
    protected static ?string $model = QnA::class;

    /**
     * Get the badge value to display next to the navigation item for this resource.
     * This method is often used to show a count of records or other relevant metrics.
     *
     * @return string|null The string value to display in the badge, or null if no badge should be shown.
     */
    public static function getNavigationBadge(): ?string
    {
        // Returns the total count of records in the 'gallery_businesses' table.
        // This count will be displayed as a small badge next to the resource's
        // navigation item in the Filament sidebar, indicating the total number of entries.
        return QnA::count();
    }

    // Specifies the navigation group under which this resource will be listed in the Filament sidebar.
    // This helps organize resources into logical categories in the admin panel.
    protected static ?string $navigationGroup = 'Content Management';

    // Sets the sorting order for this resource within its navigation group.
    // Resources with lower numbers will appear higher in the navigation menu.
    protected static ?int $navigationSort = 1;

    // Define the icon that will appear in the Filament navigation sidebar for this resource.
    // Icons are from Heroicons (heroicons.com) and improve UI readability.
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    /**
     * Define the form schema for creating and editing QnA records.
     *
     * This method configures all the input fields that users will interact with
     * when adding a new QnA item or modifying an existing one in the Filament admin panel.
     *
     * @param Form $form The Filament Form instance to define the schema on.
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Text input field for the question of the QnA item.
                Forms\Components\TextInput::make('question')
                    ->label('Question QnA') // User-friendly label displayed in the form.
                    ->required() // Marks this field as mandatory for form submission.
                    ->maxLength(255), // Sets the maximum character limit for the input, aligning with database column limits.

                // Textarea for the answer of the QnA item.
                // Textarea is used for multi-line text input.
                Forms\Components\Textarea::make('answer')
                    ->label('Answer QnA') // User-friendly label.
                    ->maxLength(255) // Sets the maximum character limit for the input.
                    // Consider using a RichEditor or removing maxLength if answers can be long.
                    ->required(), // Marks this field as mandatory.
            ]);
    }

    /**
     * Define the table schema for displaying QnA records in the Filament admin panel.
     *
     * This method configures the columns that will be displayed in the table,
     * as well as filters, actions for individual rows, and bulk actions for multiple rows.
     *
     * @param Table $table The Filament Table instance to define the schema on.
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Displays the question column.
                Tables\Columns\TextColumn::make('question')
                    ->label('Question QnA') // User-friendly label for the column header.
                    ->sortable() // Allows users to sort table data by this column in ascending/descending order.
                    ->searchable(), // Enables searching records by matching against this column's content.

                // Displays the answer column with a character limit for brevity in the table view.
                Tables\Columns\TextColumn::make('answer')
                    ->limit(50) // Limits the displayed text to the first 50 characters, appending "..." if longer.
                    ->label('Answer QnA'), // User-friendly label.
            ])
            ->filters([
                // Allows filtering records based on their soft-deleted status.
                // Options include showing all records, records with trashed items, or only trashed items.
                // This filter is available because the QnA model uses the SoftDeletes trait.
                TrashedFilter::make(),
            ])
            ->actions([
                // Action to view the full details of a single QnA record.
                Tables\Actions\ViewAction::make(),
                // Action to open the edit form for a single QnA record.
                Tables\Actions\EditAction::make(),
                // Action to soft delete a single QnA record. This moves the record to the 'trash'
                // rather than permanently removing it.
                Tables\Actions\DeleteAction::make(),
                // Action to restore a soft-deleted QnA record. This button appears only for trashed records.
                Tables\Actions\RestoreAction::make(),
                // Action to permanently delete a soft-deleted QnA record. This button appears only for trashed records,
                // allowing for final removal from the database.
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                // Groups multiple bulk actions under a single dropdown menu, applied to selected records.
                Tables\Actions\BulkActionGroup::make([
                    // Bulk action to soft delete multiple selected QnA records.
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk action to restore multiple soft-deleted QnA records.
                    Tables\Actions\RestoreBulkAction::make(),
                    // Bulk action to permanently delete multiple soft-deleted QnA records.
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Define any relationships that can be managed within this resource.
     *
     * Relation managers allow managing related models directly from a resource's view/edit pages.
     * For example, if a QnA could have 'tags', a TagRelationManager would be listed here.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // Currently, no relation managers are defined for the QnA resource.
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
            'index' => Pages\ListQnAS::route('/'),       // The main listing page for all QnA items.
            'create' => Pages\CreateQnA::route('/create'), // The page for creating a new QnA item.
            'edit' => Pages\EditQnA::route('/{record}/edit'), // The page for editing an existing QnA item, identified by its record ID.
        ];
    }
}
