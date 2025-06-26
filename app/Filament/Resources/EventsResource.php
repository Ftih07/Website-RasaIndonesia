<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventsResource\Pages;
use App\Filament\Resources\EventsResource\RelationManagers;
use App\Models\Events;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\DateFilter;
use Filament\Tables\Filters\SelectFilter;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\TrashedFilter;

// This class defines the Filament resource for managing 'Events'.
// It controls the forms for creating/editing, and the table for listing events.
class EventsResource extends Resource
{
    // Defines the Eloquent model associated with this resource.
    protected static ?string $model = Events::class;

    /**
     * Retrieves the navigation badge for the resource.
     * This method displays the total count of events next to the navigation item.
     */
    public static function getNavigationBadge(): ?string
    {
        return Events::count();
    }

    // Organizes the resource within the Filament navigation sidebar under the 'Content Management' group.
    protected static ?string $navigationGroup = 'Content Management';
    // Sets the sort order of the resource in the navigation group (lower numbers appear higher).
    protected static ?int $navigationSort = 1;
    // Specifies the Heroicon icon to be displayed next to the resource in the navigation.
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    /**
     * Defines the form schema for creating and editing events.
     * The form is structured using tabs for better organization.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main Tabs component for organizing event information.
                Tabs::make('Event Information')
                    ->tabs([
                        // Tab 1: Basic Information
                        Tabs\Tab::make('Basic Information')
                            ->icon('heroicon-m-information-circle') // Icon for the tab
                            ->schema([
                                // Section for basic event details.
                                Section::make('Event Details')
                                    ->description('Enter the basic information about the event') // Helpful description for the section
                                    ->schema([
                                        // Group fields to arrange them in columns.
                                        Group::make()
                                            ->schema([
                                                // Event Title input field.
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Event Title') // Label displayed to the user
                                                    ->placeholder('Enter event title') // Placeholder text
                                                    ->required() // Makes the field mandatory
                                                    ->maxLength(255) // Maximum character limit
                                                    ->columnSpan(2), // Spans 2 columns in a 3-column layout

                                                // Event Type input field.
                                                Forms\Components\TextInput::make('type_events')
                                                    ->label('Event Type')
                                                    ->placeholder('e.g., Food Festival, Cultural Celebration, Launch Event')
                                                    ->required()
                                                    ->maxLength(100),

                                                // Display Date input field (for display purposes only).
                                                Forms\Components\TextInput::make('date_events')
                                                    ->label('Display Date')
                                                    ->placeholder('Custom date format for display')
                                                    ->helperText('This is for display purposes only'), // Small helper text
                                            ])
                                            ->columns(3), // Arranges the fields in 3 columns

                                        // Rich Editor for event description.
                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Event Description')
                                            ->placeholder('Describe your event in detail...')
                                            ->required()
                                            ->columnSpanFull(), // Spans all available columns
                                    ])
                            ]),

                        // Tab 2: Location & Time
                        Tabs\Tab::make('Location & Schedule')
                            ->icon('heroicon-m-map-pin') // Icon for the tab
                            ->schema([
                                // Section for event location details.
                                Section::make('Event Location')
                                    ->description('Specify where the event will take place')
                                    ->schema([
                                        // Group fields for location details.
                                        Group::make()
                                            ->schema([
                                                // Venue Name input field.
                                                Forms\Components\TextInput::make('place_name')
                                                    ->label('Venue Name')
                                                    ->placeholder('e.g., Melbourne Convention Centre')
                                                    ->required()
                                                    ->maxLength(255),

                                                // Street Address input field.
                                                Forms\Components\TextInput::make('street_name')
                                                    ->label('Street Address')
                                                    ->placeholder('e.g., 1 Convention Centre Pl')
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->columns(2), // Arranges the fields in 2 columns

                                        // Map Embed Link input field.
                                        Forms\Components\TextInput::make('iframe')
                                            ->label('Map Embed Link')
                                            ->placeholder('Google Maps iframe or location link')
                                            ->helperText('Optional: Add a map link for better navigation')
                                            ->url() // Validates input as a URL
                                            ->columnSpanFull(),
                                    ]),

                                // Section for event schedule details.
                                Section::make('Event Schedule')
                                    ->description('Set the date and time for your event')
                                    ->schema([
                                        // Group fields for start and end times.
                                        Group::make()
                                            ->schema([
                                                // Start Date & Time picker.
                                                DateTimePicker::make('start_time')
                                                    ->label('Start Date & Time')
                                                    ->required()
                                                    ->timezone('Australia/Melbourne') // Sets the timezone for display/storage
                                                    ->native(false) // Uses Filament's custom date picker, not native browser one
                                                    ->displayFormat('d/m/Y H:i') // Display format for the date and time
                                                    ->helperText('Melbourne timezone'),

                                                // End Date & Time picker.
                                                DateTimePicker::make('end_time')
                                                    ->label('End Date & Time')
                                                    ->required()
                                                    ->timezone('Australia/Melbourne')
                                                    ->native(false)
                                                    ->displayFormat('d/m/Y H:i')
                                                    ->after('start_time') // Validation rule: must be after the start_time
                                                    ->helperText('Must be after start time'),
                                            ])
                                            ->columns(2), // Arranges the fields in 2 columns
                                    ])
                            ]),

                        // Tab 3: Media & Contact
                        Tabs\Tab::make('Media & Contact')
                            ->icon('heroicon-m-photo') // Icon for the tab
                            ->schema([
                                // Section for event image upload.
                                Section::make('Event Image')
                                    ->description('Upload an image to represent your event')
                                    ->schema([
                                        // File upload component for the event image.
                                        Forms\Components\FileUpload::make('image_events')
                                            ->label('Event Image')
                                            ->directory('image_events') // Directory where images will be stored
                                            ->image() // Restricts to image files
                                            ->imageEditor() // Enables image editing features (crop, rotate)
                                            ->imageEditorAspectRatios([ // Allows specific aspect ratios for image editing
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml']) // Allowed file types
                                            ->maxSize(5120) // Maximum file size in kilobytes (5MB)
                                            ->required()
                                            ->helperText('Recommended: 1920x1080px or 16:9 ratio')
                                            ->columnSpanFull(),
                                    ]),

                                // Section for organizer contact information.
                                Section::make('Organizer Contact Information')
                                    ->description('Add contact methods for event inquiries')
                                    ->schema([
                                        // Repeater for dynamic addition of contact methods.
                                        Repeater::make('contact_organizer')
                                            ->label('Contact Methods')
                                            ->schema([
                                                // Select dropdown for contact type (e.g., Phone, Email).
                                                Select::make('type')
                                                    ->label('Contact Type')
                                                    ->options([ // Predefined options for contact types
                                                        'phone' => 'Phone Number',
                                                        'email' => 'Email Address',
                                                        'website' => 'Website',
                                                        'facebook' => 'Facebook',
                                                        'instagram' => 'Instagram',
                                                        'twitter' => 'Twitter',
                                                        'linkedin' => 'LinkedIn',
                                                    ])
                                                    ->required()
                                                    ->native(false), // Uses Filament's custom select, not native browser one

                                                // Text input for the contact value.
                                                TextInput::make('value')
                                                    ->label('Contact Value')
                                                    ->placeholder('Enter contact information')
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->columns(2) // Arranges fields within repeater in 2 columns
                                            ->defaultItems(1) // Starts with one item by default
                                            ->addActionLabel('Add Contact Method') // Custom label for add button
                                            ->reorderableWithButtons() // Allows reordering items with buttons
                                            ->collapsible() // Allows collapsing repeater items
                                            ->required() // Requires at least one contact method
                                            ->minItems(1), // Minimum number of items required
                                    ])
                            ]),
                    ])
                    ->columnSpanFull() // Makes the tabs span the full width of the form
                    ->persistTabInQueryString(), // Keeps the active tab selected when navigating
            ]);
    }

    /**
     * Defines the table schema for listing events.
     * It includes columns for display, search, sorting, and filtering options.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Event Image column.
                ImageColumn::make('image_events')
                    ->label('Image')
                    ->circular() // Displays image in a circular shape
                    ->size(60), // Sets the size of the image

                // Basic Event Title column.
                TextColumn::make('title')
                    ->label('Event Title')
                    ->searchable() // Allows searching by title
                    ->sortable() // Allows sorting by title
                    ->weight('bold'), // Makes the text bold

                // Event Type column with badge styling.
                BadgeColumn::make('type_events')
                    ->label('Type')
                    ->colors([ // Defines colors based on event type
                        'primary' => 'Food Festival',
                        'success' => 'Cultural Celebration',
                        'warning' => 'Launch Event',
                        'info' => static fn($state): bool => in_array($state, ['Food Festival', 'Launch Event']), // Dynamic color for specific types
                    ])
                    ->searchable(), // Allows searching by type

                // Location Info column.
                TextColumn::make('place_name')
                    ->label('Venue')
                    ->searchable()
                    ->limit(30) // Limits text display to 30 characters
                    ->tooltip(function (TextColumn $column): ?string { // Shows full text on hover if truncated
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                // Schedule Info column, combines start and end times for display.
                TextColumn::make('schedule')
                    ->label('Schedule')
                    ->getStateUsing(function ($record): string { // Custom logic to format the schedule display
                        $start = Carbon::parse($record->start_time)->timezone('Australia/Melbourne');
                        $end = Carbon::parse($record->end_time)->timezone('Australia/Melbourne');

                        if ($start->toDateString() === $end->toDateString()) {
                            // If event is on the same day, display date and time range.
                            return $start->format('d M Y') . "\n" .
                                $start->format('h:i A') . ' - ' . $end->format('h:i A');
                        } else {
                            // If event spans multiple days, display full start and end dates/times.
                            return $start->format('d M Y h:i A') . "\n" .
                                'to ' . $end->format('d M Y h:i A');
                        }
                    })
                    ->html() // Renders the content as HTML (for line breaks)
                    ->sortable(query: function (Builder $query, string $direction): Builder { // Custom sorting based on start_time
                        return $query->orderBy('start_time', $direction);
                    }),

                // Status column with enhanced styling (colors and icons).
                BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function ($record): string { // Custom logic to determine event status
                        $now = now('Australia/Melbourne');
                        $start = Carbon::parse($record->start_time)->timezone('Australia/Melbourne');
                        $end = Carbon::parse($record->end_time)->timezone('Australia/Melbourne');

                        if ($end->isPast()) {
                            return 'Completed'; // Event has ended
                        } elseif ($start->isFuture()) {
                            return 'Upcoming'; // Event is in the future
                        } else {
                            return 'Ongoing'; // Event is currently happening
                        }
                    })
                    ->colors([ // Defines colors for different statuses
                        'success' => 'Upcoming',
                        'warning' => 'Ongoing',
                        'danger' => 'Completed',
                    ])
                    ->icons([ // Defines icons for different statuses
                        'heroicon-m-clock' => 'Upcoming',
                        'heroicon-m-play' => 'Ongoing',
                        'heroicon-m-check-circle' => 'Completed',
                    ])
                    ->sortable(), // Allows sorting by status (based on internal logic)

                // Contact Count column.
                BadgeColumn::make('contacts')
                    ->label('Contacts')
                    ->getStateUsing(fn($record) => count($record->contact_organizer ?? [])) // Displays the count of contact methods
                    ->color('gray')
                    ->suffix(' contact(s)'), // Adds a suffix to the count

                // Created Date column.
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y') // Formats the date and time
                    ->sortable()
                    ->since() // Displays time elapsed since creation (e.g., "2 days ago")
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible
            ])
            ->filters([
                // Soft Delete Filter: Allows filtering by trashed (soft-deleted) records.
                TrashedFilter::make(),

                // Status Filter: Allows filtering events by their calculated status (Upcoming, Ongoing, Completed).
                SelectFilter::make('status')
                    ->label('Event Status')
                    ->options([
                        'upcoming' => 'Upcoming Events',
                        'ongoing' => 'Ongoing Events',
                        'completed' => 'Completed Events',
                    ])
                    ->query(function (Builder $query, array $data): Builder { // Custom query logic for the filter
                        $value = $data['value'];
                        $now = now('Australia/Melbourne');

                        return match ($value) {
                            'upcoming' => $query->where('start_time', '>', $now), // Events starting in the future
                            'ongoing' => $query->where('start_time', '<=', $now) // Events started but not ended
                                ->where('end_time', '>=', $now),
                            'completed' => $query->where('end_time', '<', $now), // Events that have ended
                            default => $query, // No filter applied if no value selected
                        };
                    }),

                // Event Type Filter: Allows filtering by event type dynamically pulled from existing event types.
                SelectFilter::make('type_events')
                    ->label('Event Type')
                    ->options(function (): array { // Dynamically gets unique event types from the database
                        return Events::distinct()
                            ->pluck('type_events', 'type_events')
                            ->toArray();
                    })
                    ->searchable(), // Allows searching within the filter options

                // Date Range Filter: Allows filtering events by a custom start and end date range.
                Filter::make('date_range')
                    ->label('Event Date Range')
                    ->form([ // Defines the form fields for the filter
                        DatePicker::make('from_date')
                            ->label('From Date')
                            ->native(false),
                        DatePicker::make('to_date')
                            ->label('To Date')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder { // Custom query logic for the date range
                        return $query
                            ->when(
                                $data['from_date'],
                                fn($query) => $query->whereDate('start_time', '>=', $data['from_date']) // Filters events starting on or after 'from_date'
                            )
                            ->when(
                                $data['to_date'],
                                fn($query) => $query->whereDate('end_time', '<=', $data['to_date']) // Filters events ending on or before 'to_date'
                            );
                    })
                    ->indicateUsing(function (array $data): array { // Displays indicators for active filters
                        $indicators = [];

                        if ($data['from_date'] ?? null) {
                            $indicators[] = 'From: ' . Carbon::parse($data['from_date'])->format('d M Y');
                        }

                        if ($data['to_date'] ?? null) {
                            $indicators[] = 'To: ' . Carbon::parse($data['to_date'])->format('d M Y');
                        }

                        return $indicators;
                    }),
            ])
            ->filtersFormColumns(2) // Arranges filters in 2 columns
            ->defaultSort('start_time', 'desc') // Default sorting for the table (latest events first)
            ->striped() // Adds alternating row colors for better readability
            ->actions([
                // View action: Displays a read-only view of the event record.
                Tables\Actions\ViewAction::make()
                    ->iconButton(), // Displays as an icon button

                // Edit action: Navigates to the edit form for the event record.
                Tables\Actions\EditAction::make()
                    ->iconButton(),

                // Restore action: Restores soft-deleted event records.
                Tables\Actions\RestoreAction::make()
                    ->iconButton(),

                // Force Delete action: Permanently deletes event records.
                Tables\Actions\ForceDeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                // Group of bulk actions for selected records.
                Tables\Actions\BulkActionGroup::make([
                    // Delete Bulk Action: Soft deletes multiple selected event records.
                    Tables\Actions\DeleteBulkAction::make(),
                    // Restore Bulk Action: Restores multiple soft-deleted event records.
                    Tables\Actions\RestoreBulkAction::make(),
                    // Force Delete Bulk Action: Permanently deletes multiple selected event records.
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            // Custom messages and icons for when no events are found in the table.
            ->emptyStateHeading('No events found')
            ->emptyStateDescription('Create your first event to get started.')
            ->emptyStateIcon('heroicon-o-calendar');
    }

    /**
     * Defines any relationships that should be managed directly from this resource.
     * (Currently, no relation managers are defined for Events).
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Defines the pages associated with this resource.
     * These are the different views for interacting with event records (list, create, view, edit).
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'), // List all events
            'create' => Pages\CreateEvents::route('/create'), // Create a new event
            'view' => Pages\ViewEvents::route('/{record}'), // View a specific event
            'edit' => Pages\EditEvents::route('/{record}/edit'), // Edit a specific event
        ];
    }
}
