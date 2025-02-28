<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    // Define the model associated with this resource
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationGroup = 'Default Website';
    protected static ?int $navigationSort = 1;

    // Define the icon for navigation in Filament Admin Panel
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating and editing records
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input field for image title
                Forms\Components\TextInput::make('title')
                    ->label('Title Image')
                    ->required()
                    ->maxLength(255),
                
                // File upload component for gallery images
                Forms\Components\FileUpload::make('image')
                    ->label('Image Gallery')
                    ->directory('gallery') // Save images in the 'gallery' directory
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg']) // Allowed file types
                    ->required(),
            ]);
    }

    /**
     * Define the table schema for displaying records in the admin panel
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Display the title column
                Tables\Columns\TextColumn::make('title')
                    ->label('Title Image')
                    ->sortable()
                    ->searchable(),
                
                // Display the image column
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image Gallery'),
            ])
            ->filters([
                // No filters defined yet
            ])
            ->actions([
                // Define row actions: view, edit, delete
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Define bulk actions: delete multiple records
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Define the relationships that can be managed within this resource
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // No relations defined yet
        ];
    }

    /**
     * Define the pages associated with this resource
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'), // List all records
            'create' => Pages\CreateGallery::route('/create'), // Create a new record
            'edit' => Pages\EditGallery::route('/{record}/edit'), // Edit an existing record
        ];
    }
}