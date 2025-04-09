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

class EventsResource extends Resource
{
    protected static ?string $model = Events::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('place_name')
                    ->label('Place')
                    ->searchable(),

                TextColumn::make('start_time')
                    ->label('Start')
                    ->dateTime('D, d M Y - h:i A')
                    ->timezone('Australia/Melbourne')
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('End')
                    ->dateTime('D, d M Y - h:i A')
                    ->timezone('Australia/Melbourne')
                    ->sortable(),

                // ✅ Ini dia status event
                BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function ($record) {
                        // Ambil waktu end_time, lalu cek apakah sudah lewat atau belum
                        $endTime = Carbon::parse($record->end_time)->timezone('Australia/Melbourne');
                        return $endTime->isPast() ? 'Expired' : 'Upcoming';
                    })
                    ->colors([
                        'danger' => 'Expired',   // Warna merah
                        'success' => 'Upcoming', // Warna hijau
                    ])
                    ->sortable(),

                TextColumn::make('type_events')->label('Type')->sortable(),

                ImageColumn::make('image_events')->label('Image')->circular(),

                TextColumn::make('date_events')->label('Display Date')->toggleable(),

                BadgeColumn::make('contact_organizer')
                    ->label('Contact')
                    ->getStateUsing(fn($record) => count($record->contact_organizer) . ' contact(s)'),

                TextColumn::make('created_at')->label('Created')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                // Upcoming events
                Filter::make('Upcoming Events')
                    ->query(
                        fn(Builder $query) =>
                        $query->where('end_time', '>', now('Australia/Melbourne'))
                    ),

                // Past events
                Filter::make('Past Events')
                    ->query(
                        fn(Builder $query) =>
                        $query->where('end_time', '<=', now('Australia/Melbourne'))
                    ),

                // ✅ Filter by date range
                Filter::make('start_time_range')
                    ->label('Start Time Range')
                    ->form([
                        DatePicker::make('start_from')->label('From'),
                        DatePicker::make('start_until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_from'],
                                fn($query) =>
                                $query->whereDate('start_time', '>=', $data['start_from'])
                            )
                            ->when(
                                $data['start_until'],
                                fn($query) =>
                                $query->whereDate('start_time', '<=', $data['start_until'])
                            );
                    }),
            ])
            ->defaultSort('start_time', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
