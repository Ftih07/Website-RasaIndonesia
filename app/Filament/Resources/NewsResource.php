<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages; // Imports the 'Pages' namespace for this resource
use App\Models\News; // Imports the Eloquent model this resource manages
use Carbon\Carbon; // Imports the Carbon library for date/time manipulation
use Filament\Forms; // Namespace for Filament Form components
use Filament\Forms\Form; // Class for defining form schemas
use Filament\Resources\Resource; // Base class for Filament Resources
use Filament\Tables; // Namespace for Filament Table components
use Filament\Tables\Table; // Class for defining table schemas
use Filament\Tables\Filters\TrashedFilter; // Imports the filter for soft-deleted records
use Filament\Support\Enums\FontWeight; // Imports enum for font weight styling in tables
use Illuminate\Support\HtmlString; // Used for rendering HTML strings (though not directly used in the provided code, good to keep if needed for complex text outputs)

/**
 * Class NewsResource
 *
 * This Filament Resource is designed for managing 'News Articles' within the admin panel.
 * It provides a comprehensive and user-friendly interface for CRUD operations
 * on news content, including rich text editing, image uploads, publishing controls,
 * and advanced table functionalities like searching, sorting, and filtering.
 */
class NewsResource extends Resource
{
    // Defines the Eloquent model that this Filament resource manages.
    // All operations (create, read, update, delete) will be performed on this model.
    protected static ?string $model = News::class;

    /**
     * Retrieves the count of all news articles to display as a badge in the navigation sidebar.
     * This offers a quick overview of the total number of news entries.
     */
    public static function getNavigationBadge(): ?string
    {
        return News::count();
    }

    // Defines the navigation group under which this resource will appear in the sidebar.
    // This helps organize resources into logical categories, like 'Content Management'.
    protected static ?string $navigationGroup = 'Content Management';

    // Sets the sorting order for this resource within its navigation group.
    // Lower numbers appear higher in the list; '2' places it after 'Gallery' (if Gallery is '1').
    protected static ?int $navigationSort = 2;

    // Specifies the Heroicon to be used as the icon for this resource in the navigation.
    // 'heroicon-o-newspaper' is an outline newspaper icon.
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    // Sets the user-friendly label displayed in the Filament navigation sidebar for this resource.
    protected static ?string $navigationLabel = 'News';

    // Sets the singular label for the model, used in various parts of the UI (e.g., "New News Article").
    protected static ?string $modelLabel = 'News Article';

    // Sets the plural label for the model, used in table headings and other areas (e.g., "Listing News Articles").
    protected static ?string $pluralModelLabel = 'News Articles';

    /**
     * Defines the form schema for creating and editing News articles.
     * It uses Filament's form components, organized into tabs for better user experience.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main container for the form, using tabs to organize sections of the news article.
                Forms\Components\Tabs::make('News Article')
                    ->tabs([
                        // Tab 1: Basic Information - contains core article details.
                        Forms\Components\Tabs\Tab::make('Article Details')
                            ->icon('heroicon-m-document-text') // Icon for the tab header.
                            ->schema([
                                // A grid layout within this tab for better field arrangement.
                                Forms\Components\Grid::make(2) // Creates a 2-column grid.
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Article Title') // User-friendly label for the input.
                                            ->placeholder('Enter a compelling news title') // Placeholder text.
                                            ->required() // Makes the field mandatory.
                                            ->maxLength(255) // Sets maximum character length.
                                            ->live(onBlur: true) // Updates other fields or reactive components when input blurs.
                                            // Automatically calculates estimated reading time based on the title length (as a preliminary estimate for 'create' context).
                                            ->afterStateUpdated(function (string $context, $state, Forms\Set $set) {
                                                if ($context === 'create' && $state) { // Only on creation and if title exists.
                                                    $wordCount = str_word_count($state); // Count words in the title.
                                                    // Estimate reading time: 200 words per minute. Minimum 1 minute.
                                                    $estimatedTime = max(1, ceil($wordCount / 200));
                                                    $set('time_read', $estimatedTime); // Set the 'time_read' field.
                                                }
                                            })
                                            ->columnSpan(2), // Makes this input span both columns of the grid.

                                        Forms\Components\TextInput::make('writer')
                                            ->label('Author/Writer') // Label for the input.
                                            ->placeholder('Enter author name') // Placeholder text.
                                            ->required() // Makes the field mandatory.
                                            ->maxLength(255) // Sets maximum character length.
                                            ->prefixIcon('heroicon-m-user') // Adds a user icon as a prefix.
                                            ->columnSpan(1), // Spans one column.

                                        Forms\Components\TextInput::make('time_read')
                                            ->label('Estimated Reading Time') // Label for the input.
                                            ->numeric() // Ensures only numeric input is accepted.
                                            ->suffix(' minutes') // Adds "minutes" as a suffix to the display.
                                            ->helperText('Automatically calculated based on content length') // Helpful tips for the user.
                                            ->disabled() // Makes the field read-only as it's auto-calculated.
                                            ->columnSpan(1), // Spans one column.

                                        Forms\Components\Textarea::make('meta_keywords')
                                            ->label('Meta Keywords')
                                            ->placeholder('contoh: Indonesian food, culinary news, Taste of Indonesia, diaspora event')
                                            ->helperText('Pisahkan dengan koma untuk optimasi SEO')
                                            ->rows(2)
                                            ->maxLength(1000)
                                            ->columnSpan(2),
                                    ]),

                                Forms\Components\RichEditor::make('desc')
                                    ->label('Article Content') // Label for the rich text editor.
                                    ->placeholder('Write your news article content here...') // Placeholder text.
                                    ->required() // Makes the field mandatory.
                                    ->toolbarButtons([ // Defines the visible toolbar buttons for the rich editor.
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                                    ->live(onBlur: true) // Reacts to changes when the editor loses focus.
                                    // Automatically updates the 'time_read' field based on the article content.
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        if ($state) {
                                            $wordCount = str_word_count(strip_tags($state)); // Count words, stripping HTML tags.
                                            $estimatedTime = max(1, ceil($wordCount / 200)); // Calculate using 200 words/minute.
                                            $set('time_read', $estimatedTime); // Set the 'time_read' field.
                                        }
                                    })
                                    ->columnSpanFull(), // Spans the full width.
                            ]),

                        // Tab 2: Media & Images - for uploading the featured image.
                        Forms\Components\Tabs\Tab::make('Media')
                            ->icon('heroicon-m-photo') // Icon for the tab header.
                            ->schema([
                                Forms\Components\Section::make('Featured Image')
                                    ->description('Upload the main image for this news article')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image_news')
                                            ->label('News Image') // Label for the file upload field.
                                            ->directory('image_news') // Specifies the storage disk subdirectory.
                                            ->image() // Ensures only image files can be uploaded.
                                            ->imageEditor() // Enables Filament's built-in image editor.
                                            ->imageEditorAspectRatios([ // Defines available aspect ratios for the editor.
                                                '16:9',
                                                '4:3',
                                                '3:2',
                                                null, // Allows free-form aspect ratio.
                                            ])
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml']) // Allowed file types.
                                            ->maxSize(5120) // Sets a maximum file size limit (5120 KB = 5MB).
                                            ->required() // Makes the image upload mandatory.
                                            ->helperText('Upload a high-quality image. Recommended size: 1200x675px (16:9 ratio)') // Helpful tips.
                                            ->imagePreviewHeight('200') // Sets the height of the image preview.
                                            ->panelAspectRatio('2:1') // Sets the aspect ratio of the upload panel.
                                            ->panelLayout('integrated') // Sets the layout of the upload panel.
                                            ->columnSpanFull(), // Spans the full width.
                                    ]),
                            ]),

                        // Tab 3: Publishing Settings - controls article status and publication date.
                        Forms\Components\Tabs\Tab::make('Publishing')
                            ->icon('heroicon-m-globe-alt') // Icon for the tab header.
                            ->schema([
                                Forms\Components\Grid::make(2) // A 2-column grid within this tab.
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->label('Publication Status') // Label for the select input.
                                            ->options([ // Defines available options for the status.
                                                'draft' => 'Draft',
                                                'published' => 'Published',
                                                // 'scheduled' => 'Scheduled', // Note: 'scheduled' is used in afterStateUpdated, but not in options here.
                                            ])
                                            ->default('draft') // Sets the default status.
                                            ->required() // Makes the field mandatory.
                                            ->native(false) // Uses Filament's custom dropdown for better styling.
                                            ->live() // Makes the field reactive to changes.
                                            // Updates 'date_published' based on selected status.
                                            ->afterStateUpdated(function (callable $set, $state) {
                                                if ($state === 'published') {
                                                    $set('date_published', now()); // Set to current time if published.
                                                } elseif ($state === 'scheduled') {
                                                    $set('date_published', now()->addHour()); // Set to 1 hour from now if scheduled.
                                                }
                                            })
                                            ->helperText('Choose when this article should be available'),
                                    ]),

                                Forms\Components\DateTimePicker::make('date_published')
                                    ->label('Publication Date & Time') // Label for the date/time picker.
                                    ->default(now()) // Default to current time.
                                    ->timezone('Australia/Melbourne') // Sets the timezone for date handling.
                                    // Field is visible only if status is 'published' or 'scheduled'.
                                    ->visible(fn($get) => in_array($get('status'), ['published', 'scheduled']))
                                    ->requiredIf('status', 'published') // Required if status is 'published'.
                                    ->helperText('Set when this article should be published (Melbourne time)') // Helpful tips.
                                    ->native(false) // Uses Filament's custom picker.
                                    ->displayFormat('M j, Y g:i A') // Formats the displayed date/time.
                                    ->columnSpanFull(), // Spans the full width.
                            ]),
                    ])
                    ->columnSpanFull() // Makes the tabs container span the full width of the form.
                    ->persistTabInQueryString(), // Keeps the active tab selected even after page refresh.
            ]);
    }

    /**
     * Defines the table schema for listing News articles.
     * It uses Filament's table components to build the columns, filters, and actions.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_news')
                    ->label('Image') // Label for the column.
                    ->height(80) // Sets the height of the displayed image in the table row.
                    ->width(120) // Sets the width of the displayed image.
                    ->extraImgAttributes(['class' => 'rounded-lg object-cover']) // Adds custom CSS classes for visual styling (rounded corners, cover fit).
                    ->checkFileExistence(false), // Skips checking if the image file physically exists for performance or external storage.

                Tables\Columns\TextColumn::make('title')
                    ->label('Title') // Label for the column.
                    ->searchable() // Allows searching by this column's content.
                    ->sortable() // Allows sorting the table by this column.
                    ->weight(FontWeight::Medium) // Sets the font weight to medium.
                    ->limit(50) // Truncates the text to 50 characters.
                    // Shows the full title as a tooltip when hovered if it's truncated.
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    })
                    ->wrap(), // Wraps text if it's too long to fit in one line.

                Tables\Columns\TextColumn::make('writer')
                    ->label('Author') // Label for the column.
                    ->searchable() // Allows searching by author name.
                    ->sortable() // Allows sorting by author name.
                    ->icon('heroicon-m-user') // Adds a user icon next to the author's name.
                    ->weight(FontWeight::Medium), // Sets the font weight to medium.

                Tables\Columns\TextColumn::make('time_read')
                    ->label('Read Time') // Label for the column.
                    ->suffix(' min') // Adds "min" as a suffix (e.g., "5 min").
                    ->alignCenter() // Aligns the text to the center.
                    ->sortable(), // Allows sorting.

                Tables\Columns\TextColumn::make('status')
                    ->badge() // Displays the status as a visually distinct badge.
                    ->colors([ // Defines badge colors based on status value.
                        'warning' => 'draft',
                        'success' => 'published',
                    ])
                    // Formats the displayed status text (e.g., 'draft' becomes 'Draft').
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'draft' => 'Draft',
                            'published' => 'Published',
                            default => ucfirst($state), // Capitalize other states if they exist.
                        };
                    }),

                Tables\Columns\TextColumn::make('date_published')
                    ->label('Published') // Label for the column.
                    // Custom formatting for the publication date based on status.
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->status === 'draft' || !$state) {
                            return 'Not Published'; // If draft or no date, show 'Not Published'.
                        }
                        // Parse and format the date in 'Australia/Melbourne' timezone.
                        $carbon = Carbon::parse($state)->timezone('Australia/Melbourne');
                        return $carbon->format('M j, Y g:i A'); // e.g., "Jan 15, 2023 3:00 PM".
                    })
                    ->sortable() // Allows sorting by publication date.
                    ->toggleable(), // Allows users to show/hide this column.

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created') // Label for the column.
                    ->dateTime('M j, Y') // Formats the datetime (e.g., "Jan 15, 2023").
                    ->sortable() // Allows sorting.
                    ->since() // Displays time difference (e.g., "2 days ago").
                    ->toggleable(isToggledHiddenByDefault: true), // Allows showing/hiding, hidden by default.
            ])
            ->filters([
                TrashedFilter::make(), // Provides a filter to show only soft-deleted records or all records.

                Tables\Filters\SelectFilter::make('status') // A dropdown filter for publication status.
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Scheduled',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),

                Tables\Filters\Filter::make('published_today') // Custom filter for articles published today.
                    ->label('Published Today')
                    ->query(fn($query) => $query->whereDate('date_published', today())) // Filters by date_published matching today.
                    ->indicator('Published Today'), // Text to display as an active filter indicator.

                Tables\Filters\Filter::make('recent') // Custom filter for recently created articles.
                    ->label('Recent (Last 7 days)')
                    ->query(fn($query) => $query->where('created_at', '>=', now()->subDays(7))) // Filters by created_at in the last 7 days.
                    ->indicator('Recent'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View') // Label for the action button.
                    ->icon('heroicon-m-eye'), // Icon for the action button.

                Tables\Actions\EditAction::make()
                    ->label('Edit') // Label for the action button.
                    ->icon('heroicon-m-pencil-square'), // Icon for the action button.

                Tables\Actions\Action::make('publish') // Custom action to publish a news article.
                    ->label('Publish')
                    ->icon('heroicon-m-globe-alt')
                    ->color('success') // Green color for the button.
                    ->action(function (News $record) { // Logic when the button is clicked.
                        $record->update([
                            'status' => 'published', // Set status to 'published'.
                            'date_published' => now(), // Set publication date to now.
                        ]);
                    })
                    ->visible(fn(News $record): bool => $record->status === 'draft') // Only visible if the article is in 'draft' status.
                    ->requiresConfirmation(), // Asks for confirmation before publishing.

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

                    Tables\Actions\BulkAction::make('publish') // Custom bulk action to publish multiple news articles.
                        ->label('Publish Selected')
                        ->icon('heroicon-m-globe-alt')
                        ->color('success')
                        ->action(function ($records) { // Logic when the bulk action is performed.
                            $records->each(function ($record) { // Loop through each selected record.
                                $record->update([
                                    'status' => 'published',
                                    'date_published' => now(),
                                ]);
                            });
                        })
                        ->requiresConfirmation(), // Asks for confirmation before publishing.
                ]),
            ])
            ->defaultSort('created_at', 'desc') // Sets the default sorting order for the table (by creation date, descending).
            ->poll('60s') // Automatically refreshes the table data every 60 seconds.
            ->deferLoading() // Defers loading table data until filters/search are applied or pagination changes. Improves initial load time.
            ->striped() // Adds zebra stripping (alternating row colors) to the table for better readability.
            ->paginated([25, 50, 100]) // Defines pagination options (items per page).
            ->extremePaginationLinks() // Shows first/last page links in pagination for quick navigation.
            ->emptyStateActions([ // Actions displayed when the table is empty.
                Tables\Actions\CreateAction::make()
                    ->label('Create your first news article')
                    ->icon('heroicon-m-plus'),
            ])
            ->emptyStateHeading('No news articles yet') // Heading displayed when the table is empty.
            ->emptyStateDescription('Start by creating your first news article to share with your readers.') // Description for empty state.
            ->emptyStateIcon('heroicon-o-newspaper'); // Icon for empty state.
    }

    /**
     * Defines any relationships that should be displayed or managed directly within this resource.
     * Currently, no relationships are directly managed here, but this is where they would be defined.
     */
    public static function getRelations(): array
    {
        return [
            // Example: If News had 'comments', you could add CommentRelationManager::class here.
        ];
    }

    /**
     * Defines the pages associated with this resource and their routes.
     * This maps standard CRUD operations to their respective Filament pages.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'), // Route for listing all news articles.
            'create' => Pages\CreateNews::route('/create'), // Route for creating a new news article.
            'edit' => Pages\EditNews::route('/{record}/edit'), // Route for editing an existing news article.
            'view' => Pages\ViewNews::route('/{record}'), // Route for viewing an existing news article's details.
        ];
    }
}
