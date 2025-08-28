<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    // Specifies the model that this resource is associated with
    protected static ?string $model = Product::class;

    public static function getNavigationBadge(): ?string
    {
        return Product::count(); // Menampilkan jumlah total data booking
    }

    protected static ?string $navigationGroup = 'Business Operations';
    protected static ?int $navigationSort = 2;

    // Defines the navigation icon for the Filament admin panel
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    /**
     * Defines the form schema for creating or editing a product.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input field for business ID (must be numeric and required)
                Forms\Components\TextInput::make('business_id')
                    ->required()
                    ->numeric(),

                // Input field for product name (required with max length of 255 characters)
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // File upload field for product image (image file required)
                Forms\Components\FileUpload::make('image')
                    ->image(),

                // Input field for product type (required)
                Forms\Components\TextInput::make('type'),

                // Optional input field for serving information (default null, max length 255 characters)
                Forms\Components\TextInput::make('serving')
                    ->maxLength(255)
                    ->default(null),

                // Input field for price (required, numeric, with currency prefix)
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->label('Stock')
                    ->helperText('Available quantity of this product.'),

                // ✅ Toggle untuk status jual
                Forms\Components\Toggle::make('is_sell')
                    ->label('Sell this product?')
                    ->default(false) // defaultnya tidak dijual
                    ->helperText('If unchecked, product will be hidden from cart.'),
            ]);
    }

    /**
     * Defines the table schema for displaying products.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column for business ID (numeric and sortable)
                Tables\Columns\TextColumn::make('business.name')
                    ->label('Business')
                    ->sortable()
                    ->searchable(),

                // Column for product name (searchable)
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                // Column for product image
                Tables\Columns\ImageColumn::make('image'),

                // Column for product type
                Tables\Columns\TextColumn::make('type'),

                // Column for serving details (searchable)
                Tables\Columns\TextColumn::make('serving')
                    ->searchable(),

                // Column for price (sortable, formatted as currency)
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->sortable()
                    ->label('Stock'),

                // ✅ Kolom status jual
                Tables\Columns\IconColumn::make('is_sell')
                    ->boolean()
                    ->label('Selling?'),

                // Column for created_at timestamp (sortable, toggleable visibility)
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Column for updated_at timestamp (sortable, toggleable visibility)
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // ✅ Filter by Business
                Tables\Filters\SelectFilter::make('business_id')
                    ->label('Business')
                    ->relationship('business', 'name') // ambil kolom "name" dari tabel business
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                // Action buttons for viewing, editing, and deleting a product
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    // 🔄 Bulk update status "is_sell"
                    Tables\Actions\BulkAction::make('setSellStatus')
                        ->label('Update Selling Status')
                        ->icon('heroicon-o-shopping-cart')
                        ->form([
                            Forms\Components\Toggle::make('is_sell')
                                ->label('Sell this product?')
                                ->required(),
                        ])
                        ->action(function (array $data, $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_sell' => $data['is_sell'],
                                ]);
                            }
                        }),

                    // 📦 Bulk update stock
                    Tables\Actions\BulkAction::make('updateStock')
                        ->label('Update Stock')
                        ->icon('heroicon-o-archive-box')
                        ->form([
                            Forms\Components\TextInput::make('stock')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->label('New Stock'),
                        ])
                        ->action(function (array $data, $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'stock' => $data['stock'],
                                ]);
                            }
                        }),
                ]),
            ]);
    }

    /**
     * Defines relationships for the resource.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // Define any related models here if needed
        ];
    }

    /**
     * Defines the pages available for the resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
