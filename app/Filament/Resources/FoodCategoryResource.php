<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodCategoryResource\Pages;
use App\Models\FoodCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str; // Used for string manipulation, specifically to create slugs

// This class defines the Filament resource for managing 'FoodCategory'.
// It controls the forms for creating/editing, and the table for listing food categories.
class FoodCategoryResource extends Resource
{
    // Specifies the Eloquent model associated with this Filament resource.
    protected static ?string $model = FoodCategory::class;

    /**
     * Retrieves the navigation badge for the resource.
     * This method displays the total count of food categories next to the navigation item.
     */
    public static function getNavigationBadge(): ?string
    {
        return FoodCategory::count();
    }

    // Organizes the resource within the Filament navigation sidebar under the 'Content Management' group.
    protected static ?string $navigationGroup = 'Content Management';
    // Sets the sort order of the resource in the navigation group (lower numbers appear higher).
    // This resource will appear after 'EventsResource' which has navigationSort = 1.
    protected static ?int $navigationSort = 2;
    // Specifies the Heroicon icon to be displayed next to the resource in the navigation.
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    // Sets the label displayed in the Filament sidebar navigation for this resource.
    protected static ?string $navigationLabel = 'Food Categories';
    // Sets the singular label used throughout the Filament panel for a single record.
    protected static ?string $modelLabel = 'Food Category';
    // Sets the plural label used throughout the Filament panel for multiple records.
    protected static ?string $pluralModelLabel = 'Food Categories';

    /**
     * Defines the form schema for creating and editing food categories.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Defines a section within the form for 'Category Information'.
                Section::make('Category Information')
                    ->description('Create and manage food categories for better organization') // A helpful description for the section.
                    ->icon('heroicon-m-tag') // Icon displayed next to the section title.
                    ->schema([
                        // Text input field for the food category title (name).
                        Forms\Components\TextInput::make('title')
                            ->label('Category Name') // Label displayed to the user.
                            ->placeholder('e.g., Main Course, Appetizer, Dessert') // Placeholder text.
                            ->required() // Makes the field mandatory.
                            ->maxLength(255) // Maximum character limit.
                            // Ensures the title is unique within the FoodCategory model,
                            // ignoring the current record's title during updates.
                            ->unique(FoodCategory::class, 'title', ignoreRecord: true)
                            ->helperText('Enter a descriptive name for the food category') // Small helper text below the input.
                            ->columnSpanFull(), // Makes this input field span the full width of its parent container.
                    ])
                    ->columns(1), // Arranges fields within this section into a single column.
            ]);
    }

    /**
     * Defines the table schema for listing food categories.
     * It includes columns for display, search, sorting, filtering, and actions.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column for displaying the category's ID.
                TextColumn::make('id')
                    ->label('ID') // Label for the column header.
                    ->sortable() // Allows sorting the table by this column.
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible by user.

                // Column for displaying the category's title (name).
                TextColumn::make('title')
                    ->label('Category Name')
                    ->searchable() // Allows searching by category name.
                    ->sortable() // Allows sorting by category name.
                    ->copyable() // Allows copying the category name to the clipboard.
                    ->copyMessage('Category name copied') // Message shown after copying.
                    ->weight('bold') // Makes the text bold.
                    ->icon('heroicon-m-tag') // Displays a tag icon next to the title.
                    ->description( // Adds a smaller, secondary line of text below the title.
                        fn(FoodCategory $record): string =>
                        // Displays the category ID and creation date in the description.
                        'ID: ' . $record->id . ' • Created: ' . $record->created_at->format('M d, Y')
                    ),

                // Column to display the count of associated businesses for each category.
                TextColumn::make('businesses_count')
                    ->label('Businesses') // Label for the column.
                    ->counts('businesses') // Automatically counts the number of related 'businesses'. Requires a 'businesses' relationship in the FoodCategory model.
                    ->badge() // Displays the count as a Filament badge.
                    ->color('success') // Sets the badge color to green.
                    ->suffix(' linked') // Adds ' linked' after the count (e.g., '5 linked').
                    ->sortable() // Allows sorting by the number of linked businesses.
                    ->toggleable(), // Can be toggled visible/hidden by the user.

                // Column for displaying the creation timestamp.
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i') // Formats the date and time.
                    ->sortable()
                    ->since() // Displays time elapsed since creation (e.g., '2 days ago').
                    ->tooltip( // Shows a detailed timestamp on hover.
                        fn(FoodCategory $record): string =>
                        'Created: ' . $record->created_at->format('F j, Y \a\t g:i A')
                    )
                    ->toggleable(),

                // Column for displaying the last update timestamp.
                TextColumn::make('updated_at')
                    ->label('Last Updated') // Label for the column.
                    ->dateTime('M d, Y H:i') // Formats the date and time.
                    ->sortable()
                    ->since() // Displays time elapsed since last update.
                    ->tooltip( // Shows a detailed timestamp on hover.
                        fn(FoodCategory $record): string =>
                        'Updated: ' . $record->updated_at->format('F j, Y \a\t g:i A')
                    )
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible by user.
            ])
            ->filters([
                // Filter for 'Created Date' range.
                Tables\Filters\Filter::make('created_at')
                    ->label('Created Date')
                    ->form([ // Defines the form fields for the filter.
                        Forms\Components\DatePicker::make('created_from')->label('Created from')->native(false), // Date picker for start date.
                        Forms\Components\DatePicker::make('created_until')->label('Created until')->native(false), // Date picker for end date.
                    ])
                    ->query(function (Builder $query, array $data): Builder { // Custom query logic for filtering.
                        return $query
                            // If 'created_from' date is provided, filter records created on or after that date.
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            // If 'created_until' date is provided, filter records created on or before that date.
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array { // Displays active filter indicators above the table.
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = 'Created from ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = 'Created until ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),

                // Filter for categories that have associated businesses.
                Tables\Filters\Filter::make('has_businesses')
                    ->label('Has Businesses')
                    // Custom query: only show categories that have at least one linked business.
                    ->query(fn(Builder $query): Builder => $query->has('businesses'))
                    ->toggle(), // Displays as a toggle switch.

                // Filter for categories that do NOT have associated businesses.
                Tables\Filters\Filter::make('no_businesses')
                    ->label('No Businesses')
                    // Custom query: only show categories that have no linked businesses.
                    ->query(fn(Builder $query): Builder => $query->doesntHave('businesses'))
                    ->toggle(), // Displays as a toggle switch.
            ])
            ->filtersFormColumns(2) // Arranges the filter form fields into 2 columns.
            ->actions([
                // Groups common actions under a single button (ellipsis icon).
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('info'), // View action, styled with 'info' color.
                    Tables\Actions\EditAction::make()->color('warning'), // Edit action, styled with 'warning' color.
                    Tables\Actions\DeleteAction::make()->color('danger'), // Delete action, styled with 'danger' color.
                ])
                    ->label('Actions') // Label for the action group button.
                    ->icon('heroicon-m-ellipsis-vertical') // Ellipsis icon for the action group.
                    ->size('sm') // Small size for the button.
                    ->color('gray') // Gray color for the button.
                    ->button(), // Renders the group as a button.
            ])
            ->bulkActions([
                // Groups common bulk actions for selected records.
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Bulk delete (soft delete).
                    Tables\Actions\RestoreBulkAction::make(), // Bulk restore (for soft-deleted records).
                    Tables\Actions\ForceDeleteBulkAction::make(), // Bulk force delete (permanent deletion).
                    // Custom bulk action to export selected food categories to a CSV file.
                    Tables\Actions\BulkAction::make('export')
                        ->label('Export Selected') // Label for the export button.
                        ->icon('heroicon-m-arrow-down-tray') // Download icon.
                        ->action(function ($records) { // Defines the action logic.
                            // Streams a CSV file download.
                            return response()->streamDownload(function () use ($records) {
                                echo "ID,Category Name,Created At\n"; // CSV header row.
                                foreach ($records as $record) {
                                    // Outputs each record's ID, title, and creation date.
                                    echo "{$record->id},{$record->title},{$record->created_at}\n";
                                }
                            }, 'food-categories.csv'); // File name for the download.
                        })
                        ->requiresConfirmation() // Asks for confirmation before exporting.
                        ->color('success'), // Green color for the button.
                ]),
            ])
            ->defaultSort('created_at', 'desc') // Default sorting: newest categories first.
            ->striped() // Adds alternating row colors for better readability.
            ->persistSortInSession() // Remembers user's sorting preference across sessions.
            ->persistSearchInSession() // Remembers user's search query across sessions.
            ->persistFiltersInSession() // Remembers user's active filters across sessions.
            // Custom messages and icon for when no food categories are found in the table.
            ->emptyStateHeading('No food categories found')
            ->emptyStateDescription('Create your first food category to organize your menu items.')
            ->emptyStateIcon('heroicon-o-tag')
            ->emptyStateActions([
                // Action button in the empty state message to create a new category.
                Tables\Actions\CreateAction::make()->label('Create Food Category'),
            ]);
    }

    /**
     * Defines any relationships that should be managed directly from this resource.
     * (Currently, no relation managers are defined for FoodCategory).
     */
    public static function getRelations(): array
    {
        return [
            // Add relation managers here if needed, e.g., to manage 'FoodItems' associated with a category directly.
        ];
    }

    /**
     * Defines the pages associated with this resource.
     * These are the different views for interacting with food category records (list, create, view, edit).
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFoodCategories::route('/'), // Lists all food categories.
            'create' => Pages\CreateFoodCategory::route('/create'), // Form to create a new food category.
            'view' => Pages\ViewFoodCategory::route('/{record}'), // Displays details of a specific food category.
            'edit' => Pages\EditFoodCategory::route('/{record}/edit'), // Form to edit a specific food category.
        ];
    }

    /**
     * Modifies the Eloquent query used for global search.
     * This ensures that when searching globally, related 'businesses' data is eagerly loaded.
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        // Adds a 'with' clause to eager load the 'businesses' relationship.
        // This is important if you plan to search or display data from related businesses.
        return parent::getGlobalSearchEloquentQuery()->with(['businesses']);
    }

    /**
     * Defines which attributes (database columns) should be searchable in the global search bar.
     * Only the 'title' column of the FoodCategory model will be searched globally.
     */
    public static function getGlobalSearchAttributes(): array
    {
        return ['title'];
    }
}
