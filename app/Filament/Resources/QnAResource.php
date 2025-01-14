<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QnAResource\Pages;
use App\Filament\Resources\QnAResource\RelationManagers;
use App\Models\QnA;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QnAResource extends Resource
{
    protected static ?string $model = QnA::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('question')
                    ->label('Question QnA')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('answer')
                    ->label('Answer QnA')
                    ->maxLength(255)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('question')
                    ->label('Question QnA')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('answer')
                    ->limit(50)
                    ->label('Answer QnA'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListQnAS::route('/'),
            'create' => Pages\CreateQnA::route('/create'),
            'edit' => Pages\EditQnA::route('/{record}/edit'),
        ];
    }
}
