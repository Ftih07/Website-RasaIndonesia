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
    // Define the model that this resource will be managing
    protected static ?string $model = QnA::class;

    protected static ?string $navigationGroup = 'Default Website';
    protected static ?int $navigationSort = 1;

    // Set the navigation icon for this resource in the Filament admin panel
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating and editing QnA records.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Text input for the question field
                Forms\Components\TextInput::make('question')
                    ->label('Question QnA')
                    ->required() // Field is required
                    ->maxLength(255), // Maximum length of 255 characters

                // Textarea for the answer field
                Forms\Components\Textarea::make('answer')
                    ->label('Answer QnA')
                    ->maxLength(255) // Limit to 255 characters
                    ->required(), // Field is required
            ]);
    }

    /**
     * Define the table schema for listing QnA records.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Display the question column
                Tables\Columns\TextColumn::make('question')
                    ->label('Question QnA')
                    ->sortable() // Allow sorting
                    ->searchable(), // Allow searching

                // Display the answer column with a character limit
                Tables\Columns\TextColumn::make('answer')
                    ->limit(50) // Limit display to 50 characters
                    ->label('Answer QnA'),
            ])
            ->filters([
                // Filters can be added here
            ])
            ->actions([
                // View action
                Tables\Actions\ViewAction::make(),
                // Edit action
                Tables\Actions\EditAction::make(),
                // Delete action
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Bulk delete action
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Define any relationships for this resource.
     */
    public static function getRelations(): array
    {
        return [
            // Add relation managers if needed
        ];
    }

    /**
     * Define the pages for this resource.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQnAS::route('/'), // Route for listing records
            'create' => Pages\CreateQnA::route('/create'), // Route for creating a record
            'edit' => Pages\EditQnA::route('/{record}/edit'), // Route for editing a record
        ];
    }
}
