<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeResource\Pages;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * TypeResource Class
 * 
 * This resource handles CRUD operations for the `Type` model using Filament.
 */
class TypeResource extends Resource
{
    /**
     * @var string|null The associated model for this resource.
     */
    protected static ?string $model = Type::class;

    /**
     * @var string|null The navigation group where this resource will be categorized in the admin panel.
     */
    protected static ?string $navigationGroup = 'Default Website';

    /**
     * @var int|null The sort order of this resource in the navigation.
     */
    protected static ?int $navigationSort = 1;

    /**
     * @var string|null The icon for this resource in the Filament navigation.
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the form schema for creating and editing records.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Text input field for the business type title
                Forms\Components\TextInput::make('title')
                    ->label('Type Business')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    /**
     * Define the table schema for listing records.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column to display the business type title
                Tables\Columns\TextColumn::make('title')
                    ->label('Type Business')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Define table filters here if needed
            ])
            ->actions([
                // View action to display record details
                Tables\Actions\ViewAction::make(),
                // Edit action to modify records
                Tables\Actions\EditAction::make(),
                // Delete action to remove records
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
     * Define related resources or models.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // Define relationships here if necessary
        ];
    }

    /**
     * Define the pages for this resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTypes::route('/'),
            'create' => Pages\CreateType::route('/create'),
            'edit' => Pages\EditType::route('/{record}/edit'),
        ];
    }
}
