<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryBusinessResource\Pages;
use App\Filament\Resources\GalleryBusinessResource\RelationManagers;
use App\Models\GalleryBusiness;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryBusinessResource extends Resource
{
    // Defines the associated model for this resource
    protected static ?string $model = GalleryBusiness::class;

    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 2;

    // Sets the navigation icon for this resource in Filament admin panel
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Defines the form structure for creating and editing records
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('business_id')
                    ->required() // Field is required
                    ->numeric(), // Ensures input is a numeric value
                
                Forms\Components\TextInput::make('title')
                    ->required() // Field is required
                    ->maxLength(255), // Sets maximum length for input
                
                Forms\Components\FileUpload::make('image')
                    ->image() // Ensures uploaded file is an image
                    ->required(), // Field is required
            ]);
    }

    // Defines the table structure for displaying records
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business_id')
                    ->numeric() // Ensures numeric display
                    ->sortable(), // Allows sorting by business_id
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable(), // Enables search functionality
                
                Tables\Columns\ImageColumn::make('image'), // Displays image in table
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime() // Formats as date-time
                    ->sortable() // Allows sorting by created_at
                    ->toggleable(isToggledHiddenByDefault: true), // Can be hidden by default
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime() // Formats as date-time
                    ->sortable() // Allows sorting by updated_at
                    ->toggleable(isToggledHiddenByDefault: true), // Can be hidden by default
            ])
            ->filters([
                // Filters can be added here
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Adds view action
                Tables\Actions\DeleteAction::make(), // Adds delete action
                Tables\Actions\EditAction::make(), // Adds edit action
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Adds bulk delete action
                ]),
            ]);
    }

    // Defines relationships for this resource
    public static function getRelations(): array
    {
        return [
            // Relationships can be added here
        ];
    }

    // Defines the pages associated with this resource
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryBusinesses::route('/'), // List page
            'create' => Pages\CreateGalleryBusiness::route('/create'), // Create page
            'edit' => Pages\EditGalleryBusiness::route('/{record}/edit'), // Edit page
        ];
    }
}
