<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodCategoryResource\Pages;
use App\Filament\Resources\FoodCategoryResource\RelationManagers;
use App\Models\FoodCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

// Defines a Filament resource for managing Food Categories
class FoodCategoryResource extends Resource
{
    // Specifies the Eloquent model associated with this resource
    protected static ?string $model = FoodCategory::class;

    protected static ?string $navigationGroup = 'Default Website';
    protected static ?int $navigationSort = 1;

    // Sets the navigation icon for the resource in the Filament admin panel
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Defines the form schema for creating and editing Food Categories
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input field for food category title
                Forms\Components\TextInput::make('title')
                    ->label('Type Food Category')
                    ->required() // Makes the field mandatory
                    ->maxLength(255), // Restricts input length to 255 characters
            ]);
    }

    // Defines the table schema for displaying Food Categories in the admin panel
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Displays the food category title in the table
                Tables\Columns\TextColumn::make('title')
                    ->label('Food Category')
                    ->sortable() // Allows sorting by this column
                    ->searchable(), // Enables searching for this column
            ])
            ->filters([
                // No filters are defined for this resource yet
            ])
            ->actions([
                // Defines available actions: View, Edit, Delete
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Allows bulk deletion of records
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Defines relationships (none are specified for now)
    public static function getRelations(): array
    {
        return [
            // Relationships can be added here
        ];
    }

    // Defines the pages for this resource, mapping them to respective routes
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFoodCategories::route('/'), // List page
            'create' => Pages\CreateFoodCategory::route('/create'), // Create page
            'edit' => Pages\EditFoodCategory::route('/{record}/edit'), // Edit page
        ];
    }
}
