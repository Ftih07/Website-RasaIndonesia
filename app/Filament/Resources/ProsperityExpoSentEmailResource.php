<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProsperityExpoSentEmailResource\Pages;
use App\Filament\Resources\ProsperityExpoSentEmailResource\RelationManagers;
use App\Models\ProsperityExpoSentEmail;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Mail\ProsperityExpoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

class ProsperityExpoSentEmailResource extends Resource
{
    protected static ?string $model = ProsperityExpoSentEmail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Prosperity Expo';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('recipient_name'),
            TextInput::make('email')->email()->required(),
            TextInput::make('company_brand'),
            TextInput::make('participant_type'),
            TextInput::make('link'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('recipient_name'),
                TextColumn::make('email'),
                TextColumn::make('sent_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('sendEmail')
                    ->label('Send Email')
                    ->color('success')
                    ->action(function ($record) {
                        Mail::to($record->email)->send(new ProsperityExpoMail($record));

                        $record->update(['sent_at' => now()]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('sendSelectedEmails')
                    ->label('Send Selected Emails')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            Mail::to($record->email)->send(new \App\Mail\ProsperityExpoMail($record));

                            $record->update(['sent_at' => now()]);
                        }
                    })
                    ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListProsperityExpoSentEmails::route('/'),
            'create' => Pages\CreateProsperityExpoSentEmail::route('/create'),
            'edit' => Pages\EditProsperityExpoSentEmail::route('/{record}/edit'),
        ];
    }

    /**
     * Get navigation badge (show count of participants)
     * This method displays the total number of participants next to the navigation item in the sidebar.
     *
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        // Counts all records in the associated model's table.
        return static::getModel()::count();
    }
}
