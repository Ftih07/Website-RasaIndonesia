<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatResource\Pages;
use App\Filament\Resources\ChatResource\RelationManagers;
use App\Models\Chat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;

class ChatResource extends Resource
{
    protected static ?string $model = Chat::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Chats';
    protected static ?string $pluralLabel = 'Chats';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('Detail Chat')
                    ->content('Gunakan tab Messages untuk melihat isi chat.')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business.name')
                    ->label('Business')
                    ->default('-'),
                Tables\Columns\TextColumn::make('userOne.name')
                    ->label('User One'),
                Tables\Columns\TextColumn::make('userTwo.name')
                    ->label('User Two'),
                Tables\Columns\TextColumn::make('latest_message_text')
                    ->label('Last Message')
                    ->placeholder('-')
                    ->wrap(false)
                    ->limit(30),
                Tables\Columns\TextColumn::make('unread_count')
                    ->label('Unread')
                    ->badge()
                    ->color(fn($state) => $state > 0 ? 'danger' : 'gray')
                    ->sortable()
                    ->default(0),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Last Update')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export Messages')
                    ->form([
                        Forms\Components\Select::make('business_id')
                            ->label('Business')
                            ->relationship('business', 'name')
                            ->searchable(),

                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date'),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date'),
                    ])
                    ->action(function (array $data) {
                        return Excel::download(
                            new \App\Exports\ChatMessagesExport(
                                $data['business_id'] ?? null,
                                $data['start_date'] ?? null,
                                $data['end_date'] ?? null,
                            ),
                            'chat-messages.xlsx'
                        );
                    }),
            ])
            ->filters([
                // ✅ Filter berdasarkan bisnis
                Tables\Filters\SelectFilter::make('business_id')
                    ->label('Business')
                    ->relationship('business', 'name'),

                // ✅ Filter berdasarkan rentang waktu (Last Update)
                Tables\Filters\Filter::make('updated_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $q, $date) => $q->whereDate('updated_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $q, $date) => $q->whereDate('updated_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->poll('5s'); // auto refresh tiap 5 detik
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'view' => Pages\ViewChat::route('/{record}'),
        ];
    }
}
