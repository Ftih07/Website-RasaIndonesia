<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StickerResource\Pages;
use App\Filament\Resources\StickerResource\RelationManagers;
use App\Models\Sticker;
use App\Http\Controllers\StickerController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StickerResource extends Resource
{
    protected static ?string $model = Sticker::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('business_id')
                    ->label('Restaurant Name')
                    ->options(\App\Models\Business::whereNotIn('id', \App\Models\Sticker::pluck('business_id'))
                        ->pluck('name', 'id')) // Hanya bisnis yang belum punya stiker
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('unique_code')
                    ->label('Unique Code')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business.name')
                    ->label('Restaurant Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unique_code')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('pdf_path')
                    ->url(fn($record) => asset('storage/' . $record->pdf_path), true)
                    ->label('Download Sticker'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('generate_pdf')
                    ->label('Generate PDF')
                    ->action(fn($record) => app(StickerController::class)->generate($record))
                    ->color('primary'),
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
            'index' => Pages\ListStickers::route('/'),
            'create' => Pages\CreateSticker::route('/create'),
            'edit' => Pages\EditSticker::route('/{record}/edit'),
        ];
    }
}
