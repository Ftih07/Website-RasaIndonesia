<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QrLinkResource\Pages;
use App\Filament\Resources\QrLinkResource\RelationManagers;
use App\Models\QrLink;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QrLinkResource extends Resource
{
    protected static ?string $model = QrLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                Textarea::make('url')->required()->label('Website URL'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('url')->limit(30),
                Tables\Columns\ImageColumn::make('qr_path')
                    ->label('QR Code')
                    ->disk('public')
                    ->visibility('visible')
                    ->height(100),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(), // <-- tambahkan ini
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Generate QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('primary')
                    ->action(function ($record) {
                        app(\App\Http\Controllers\QrLinkDownloadController::class)->generateAndSave($record->id);
                    })
                    ->requiresConfirmation()
                    ->label('Generate & Save QR'),
                Tables\Actions\Action::make('Download QR')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn($record) => route('qr.download', $record->id))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListQrLinks::route('/'),
            'create' => Pages\CreateQrLink::route('/create'),
            'edit' => Pages\EditQrLink::route('/{record}/edit'),
        ];
    }
}
