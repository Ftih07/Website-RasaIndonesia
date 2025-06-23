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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\DateFilter;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\TrashedFilter; //new

class EventsResource extends Resource
{
    protected static ?string $model = Events::class;

    public static function getNavigationBadge(): ?string
    {
        return Events::count(); // Menampilkan jumlah total data booking
    }

    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('title')
                    ->label('Events Title')
                    ->required(),
                Forms\Components\TextInput::make('place_name')
                    ->label('Name Place Event')
                    ->required(),
                Forms\Components\TextInput::make('street_name')
                    ->label('Street Name')
                    ->required(),

                DateTimePicker::make('start_time')
                    ->label('Start Time')
                    ->required()
                    ->timezone('Australia/Melbourne'),
                DateTimePicker::make('end_time')
                    ->label('End Time')
                    ->required()
                    ->timezone('Australia/Melbourne'),
                Forms\Components\TextInput::make('date_events')
                    ->label('Date Event'),

                Forms\Components\TextInput::make('type_events')
                    ->label('Type Event')
                    ->required(),
                Forms\Components\FileUpload::make('image_events')
                    ->label('Related Image Events')
                    ->directory('image_events') // Save images in the 'gallery' directory
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg']) // Allowed file types
                    ->required(),
                Forms\Components\RichEditor::make('desc')
                    ->label('Desc Event')
                    ->required(),

                Forms\Components\TextInput::make('iframe')
                    ->label('Iframe Link'),

                Repeater::make('contact_organizer')
                    ->label('Contact Event Organizer')
                    ->schema([
                        Select::make('type')
                            ->label('Contact Type')
                            ->options([
                                'phone' => 'Phone',
                                'website' => 'Website',
                                'facebook' => 'Facebook',
                                'instagram' => 'Instagram',
                            ])
                            ->required(),
                        TextInput::make('value')
                            ->label('Value')
                            ->required(),
                    ])
                    ->columns(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Displays the event title.
                TextColumn::make('title')
                    ->label('Title') // User-friendly label for the column header.
                    ->searchable() // Allows searching records by this column.
                    ->sortable(), // Allows sorting records by this column.

                // Displays the name of the place where the event is held.
                TextColumn::make('place_name')
                    ->label('Place') // User-friendly label.
                    ->searchable(), // Allows searching records by this column.

                // Displays the event's start time.
                TextColumn::make('start_time')
                    ->label('Start') // User-friendly label.
                    // Formats the datetime string for display (e.g., "Mon, 01 Jan 2024 - 09:00 AM").
                    ->dateTime('D, d M Y - h:i A')
                    // Sets the timezone for displaying the datetime. Essential for correct time representation.
                    ->timezone('Australia/Melbourne')
                    ->sortable(), // Allows sorting records by this column.

                // Displays the event's end time.
                TextColumn::make('end_time')
                    ->label('End') // User-friendly label.
                    // Formats the datetime string for display.
                    ->dateTime('D, d M Y - h:i A')
                    // Sets the timezone for displaying the datetime.
                    ->timezone('Australia/Melbourne')
                    ->sortable(), // Allows sorting records by this column.

                // Displays the event's status (Expired or Upcoming) as a colored badge.
                BadgeColumn::make('status')
                    ->label('Status') // User-friendly label.
                    // Dynamically determines the status based on the event's end time.
                    ->getStateUsing(function ($record): string {
                        // Parses the end_time and sets its timezone to 'Australia/Melbourne'.
                        $endTime = Carbon::parse($record->end_time)->timezone('Australia/Melbourne');
                        // Returns 'Expired' if the end time is in the past, otherwise 'Upcoming'.
                        return $endTime->isPast() ? 'Expired' : 'Upcoming';
                    })
                    // Defines the colors for each status value.
                    ->colors([
                        'danger' => 'Expired',   // Red color for 'Expired' status.
                        'success' => 'Upcoming', // Green color for 'Upcoming' status.
                    ])
                    ->sortable(), // Allows sorting records by this calculated status.

                // Displays the type of event.
                TextColumn::make('type_events')
                    ->label('Type') // User-friendly label.
                    ->sortable(), // Allows sorting records by this column.

                // Displays the event's image in a circular format.
                ImageColumn::make('image_events')
                    ->label('Image') // User-friendly label.
                    ->circular(), // Renders the image as a circle.

                // Displays a custom formatted date string for events.
                // This column can be toggled on/off by the user in the table settings.
                TextColumn::make('date_events')
                    ->label('Display Date')
                    ->toggleable(),

                // Displays the number of contacts for the organizer as a badge.
                BadgeColumn::make('contact_organizer')
                    ->label('Contact') // User-friendly label.
                    // Dynamically generates the badge text based on the count of contacts.
                    ->getStateUsing(fn($record) => count($record->contact_organizer) . ' contact(s)'),

                // Displays the creation date of the event.
                TextColumn::make('created_at')
                    ->label('Created') // User-friendly label.
                    ->dateTime('d M Y') // Formats the creation date (e.g., "01 Jan 2024").
                    ->sortable(), // Allows sorting records by creation date.
            ])
            ->filters([
                // Allows filtering records by their soft-deleted status (all, with trashed, only trashed).
                TrashedFilter::make(),

                // Custom filter to show only events that are upcoming (end_time is in the future).
                Filter::make('Upcoming Events')
                    ->query(
                        fn(Builder $query) =>
                        // Adds a 'where' clause to the query to fetch events where 'end_time' is greater than the current time.
                        $query->where('end_time', '>', now('Australia/Melbourne'))
                    ),

                // Custom filter to show only events that have already passed (end_time is in the past).
                Filter::make('Past Events')
                    ->query(
                        fn(Builder $query) =>
                        // Adds a 'where' clause to the query to fetch events where 'end_time' is less than or equal to the current time.
                        $query->where('end_time', '<=', now('Australia/Melbourne'))
                    ),

                // Custom filter to allow filtering events by a range of start dates.
                Filter::make('start_time_range')
                    ->label('Start Time Range') // User-friendly label for the filter.
                    ->form([
                        // Date picker for the start of the date range.
                        DatePicker::make('start_from')->label('From'),
                        // Date picker for the end of the date range.
                        DatePicker::make('start_until')->label('Until'),
                    ])
                    // Defines the query logic for this filter based on the selected dates.
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            // Applies a 'whereDate' condition if 'start_from' date is provided.
                            ->when(
                                $data['start_from'],
                                fn($query) =>
                                $query->whereDate('start_time', '>=', $data['start_from'])
                            )
                            // Applies a 'whereDate' condition if 'start_until' date is provided.
                            ->when(
                                $data['start_until'],
                                fn($query) =>
                                $query->whereDate('start_time', '<=', $data['start_until'])
                            );
                    }),
            ])
            // Sets the default sorting for the table to 'start_time' in descending order.
            ->defaultSort('start_time', 'desc')
            ->actions([
                // Action to edit a single event record.
                Tables\Actions\EditAction::make(),
                // Action to restore a soft-deleted event record. Appears only for trashed records.
                Tables\Actions\RestoreAction::make(),
                // Action to permanently delete a soft-deleted event record. Appears only for trashed records.
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                // Groups multiple bulk actions under a single dropdown menu.
                Tables\Actions\BulkActionGroup::make([
                    // Bulk action to soft delete multiple selected event records.
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk action to restore multiple soft-deleted event records.
                    Tables\Actions\RestoreBulkAction::make(),
                    // Bulk action to permanently delete multiple soft-deleted event records.
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvents::route('/create'),
            'edit' => Pages\EditEvents::route('/{record}/edit'),
        ];
    }
}
