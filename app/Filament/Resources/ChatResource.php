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
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Last Update'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'view' => Pages\ViewChat::route('/{record}'),
        ];
    }
}