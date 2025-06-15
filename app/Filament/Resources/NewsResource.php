<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News; // Import the News Eloquent model.
use Carbon\Carbon; // Import Carbon for date and time manipulation.
use Filament\Forms; // Namespace for Filament Form components.
use Filament\Forms\Form; // Class for defining a Filament Form.
use Filament\Resources\Resource; // Base class for Filament Resources.
use Filament\Tables; // Namespace for Filament Table components.
use Filament\Tables\Table; // Class for defining a Filament Table.
use Filament\Forms\Components\TextInput; // Form component for single-line text input.
use Filament\Forms\Components\DateTimePicker; // Form component for date and time selection.
use Filament\Forms\Components\RichEditor; // Form component for rich text editing.
use Filament\Forms\Components\Select; // Form component for dropdown selection.
use Filament\Tables\Columns\BadgeColumn; // Table column to display content as a colored badge.
use Filament\Tables\Columns\TextColumn; // Table column to display simple text.
use Filament\Tables\Filters\TrashedFilter; // Table filter to show soft-deleted records.

/**
 * Class NewsResource
 *
 * This Filament Resource defines the administrative interface for the News model.
 * It configures the forms for creating/editing news, the table for listing news,
 * and handles relationships and page routing within the Filament admin panel.
 */
class NewsResource extends Resource
{
    // Define the Eloquent model that this resource manages.
    protected static ?string $model = News::class;

    // Set the icon that will appear in the Filament navigation sidebar for this resource.
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating and editing News records.
     *
     * @param Form $form The Filament Form instance.
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Text input for the news article's title.
                Forms\Components\TextInput::make('title')
                    ->label('News Title') // User-friendly label for the input field.
                    ->required(), // Makes this field mandatory.

                // File upload component for the news article's main image.
                Forms\Components\FileUpload::make('image_news')
                    ->label('Related News Image') // User-friendly label.
                    ->directory('image_news') // Specifies the disk subdirectory where uploaded files will be stored.
                    ->image() // Validates that the uploaded file is an image.
                    // Defines accepted MIME types for file uploads, enhancing client-side validation.
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg'])
                    ->required(), // Makes this field mandatory.

                // Text input for the news article's writer/author.
                Forms\Components\TextInput::make('writer')
                    ->label('News Writer') // User-friendly label.
                    ->required(), // Makes this field mandatory.

                // Date and time picker for setting the publication time of the news.
                DateTimePicker::make('date_published')
                    ->label('Publish Time') // User-friendly label.
                    ->default(now()) // Sets the default value to the current date and time.
                    // Ensures the selected time is handled in the 'Australia/Melbourne' timezone.
                    ->timezone('Australia/Melbourne')
                    // This field is only visible if the 'status' field is set to 'published'.
                    ->visible(fn($get) => $get('status') === 'published')
                    // This field is required only if the 'status' field is set to 'published'.
                    ->requiredIf('status', 'published'),

                // Text input to display the estimated reading time.
                TextInput::make('time_read')
                    ->numeric() // Ensures the input is treated as a number.
                    ->suffix(' minutes') // Adds 'minutes' as a suffix to the displayed value.
                    ->disabled(), // Disables the input field, preventing manual user edits.
                // The value for this field is typically calculated automatically in the model.

                // Select dropdown for choosing the news article's status.
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',       // Option for a draft status.
                        'published' => 'Published', // Option for a published status.
                    ])
                    ->default('draft') // Sets the default status to 'draft'.
                    ->required() // Makes this field mandatory.
                    // A callback function that runs after the status field's state is updated.
                    ->afterStateUpdated(function (callable $set, $state) {
                        // If the status is changed to 'published', automatically set 'date_published' to the current time.
                        if ($state === 'published') {
                            $set('date_published', now());
                        }
                    }),

                // Rich text editor for the news article's main content/description.
                RichEditor::make('desc')
                    ->required() // Makes this field mandatory.
                    ->columnSpanFull(), // Makes this component span the full width of the form layout.
            ]);
    }

    /**
     * Define the table schema for listing News records.
     *
     * @param Table $table The Filament Table instance.
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Displays the news article title, allowing searching.
                TextColumn::make('title')
                    ->searchable(), // Enables searching records by this column.

                // Displays the name of the news writer.
                TextColumn::make('writer'),

                // Displays the estimated reading time.
                TextColumn::make('time_read')
                    ->label('Time Read') // User-friendly label.
                    ->suffix(' minute'), // Adds 'minute' as a suffix.

                // Displays the publication date and time, with custom formatting.
                TextColumn::make('date_published')
                    ->label('Date Published') // User-friendly label.
                    // Custom formatting logic for the displayed state.
                    ->formatStateUsing(function ($state, $record) {
                        // If the news status is 'draft' or 'date_published' is null, display "Not Published".
                        if ($record->status === 'draft' || !$state) {
                            return 'Not Published';
                        }

                        // Parse the date and set its timezone to 'Australia/Melbourne'.
                        $carbon = Carbon::parse($state)->timezone('Australia/Melbourne');

                        // Format specific parts of the date for display.
                        $time = $carbon->format('g:i A');     // E.g., "8:00 AM"
                        $tzAbbr = $carbon->format('T');       // E.g., "AEDT" or "AEST"
                        $date = $carbon->format('D M j, Y');  // E.g., "Sat Mar 22, 2025"

                        // Return the combined formatted string.
                        return "Published {$time} {$tzAbbr} (Melbourne Time), {$date}";
                    })
                    ->sortable() // Allows sorting records by this column.
                    ->searchable(), // Allows searching records by this formatted column.

                // Displays the news article's status as a colored badge.
                BadgeColumn::make('status')
                    // Defines specific colors for different status values.
                    ->colors([
                        'secondary' => 'draft',     // Secondary color for 'draft' status.
                        'success' => 'published', // Success color for 'published' status.
                    ])
                    // Customizes the displayed text for each status value.
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'draft' => 'Draft',       // Displays 'Draft' for 'draft' status.
                            'published' => 'Published', // Displays 'Published' for 'published' status.
                            default => ucfirst($state), // Capitalizes other status values.
                        };
                    }),
            ])
            ->filters([
                // Allows filtering records by their soft-deleted status (all, with trashed, only trashed).
                TrashedFilter::make(),
            ])
            ->actions([
                // Action to open the edit form for a single news record.
                Tables\Actions\EditAction::make(),
                // Action to restore a soft-deleted news record. This button appears only for trashed records.
                Tables\Actions\RestoreAction::make(),
                // Action to permanently delete a soft-deleted news record. This button appears only for trashed records.
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                // Groups multiple bulk actions under a single dropdown menu.
                Tables\Actions\BulkActionGroup::make([
                    // Bulk action to soft delete multiple selected news records.
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk action to restore multiple soft-deleted news records.
                    Tables\Actions\RestoreBulkAction::make(),
                    // Bulk action to permanently delete multiple soft-deleted news records.
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Define the relation managers that can be attached to this resource.
     * Relation managers allow managing related models directly from the resource's pages.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // No relation managers are currently defined for the News resource.
        ];
    }

    /**
     * Define the pages associated with this resource.
     * Pages define the routes and components for different views (e.g., list, create, edit).
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),       // The main listing page for news.
            'create' => Pages\CreateNews::route('/create'), // The page for creating a new news article.
            'edit' => Pages\EditNews::route('/{record}/edit'), // The page for editing an existing news article.
        ];
    }
}
