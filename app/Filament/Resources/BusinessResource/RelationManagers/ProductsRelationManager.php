<?php

namespace App\Filament\Resources\BusinessResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products'; // relasi dari Business model

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('product-images'),

                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                Forms\Components\TextInput::make('weight')
                    ->numeric()
                    ->suffix('gr'),

                Forms\Components\TextInput::make('length')
                    ->numeric()
                    ->suffix('cm'),

                Forms\Components\TextInput::make('width')
                    ->numeric()
                    ->suffix('cm'),

                Forms\Components\TextInput::make('height')
                    ->numeric()
                    ->suffix('cm'),

                Forms\Components\TextInput::make('serving'),

                Forms\Components\RichEditor::make('desc')
                    ->label('Description')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'link',
                        'orderedList',
                        'bulletList',
                        'blockquote',
                        'codeBlock',
                    ])
                    ->columnSpanFull(), // biar full width di form

                Forms\Components\TextInput::make('max_distance')
                    ->label('Max Distance (km)')
                    ->numeric()
                    ->minValue(1)
                    ->helperText('Produk hanya tersedia dalam radius ini dari lokasi user'),

                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Available quantity of this product.'),

                // ✅ Toggle untuk status jual
                Forms\Components\Toggle::make('is_sell')
                    ->label('Sell this product?')
                    ->default(false) // defaultnya tidak dijual
                    ->helperText('If unchecked, product will be hidden from cart.'),

                Forms\Components\MultiSelect::make('optionGroups')
                    ->label('Option Groups')
                    ->relationship(
                        name: 'optionGroups',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (\Illuminate\Database\Eloquent\Builder $query) {
                            $query->where('business_id', $this->getOwnerRecord()->id);
                        },
                    ),

                Forms\Components\MultiSelect::make('categories')
                    ->label('Categories')
                    ->relationship(
                        name: 'categories',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (\Illuminate\Database\Eloquent\Builder $query) {
                            $query->where('business_id', $this->getOwnerRecord()->id);
                        },
                    ),

            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->square(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->money('AUD')->sortable(),
                Tables\Columns\TextColumn::make('stock')->sortable(),
                Tables\Columns\IconColumn::make('is_sell')->boolean(),

                // ✅ Tambahin kolom categories
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge() // biar tiap category jadi badge
                    ->separator(', ') // kalau ada banyak, dipisah koma
                    ->sortable()
                    ->toggleable(), // bisa disembunyiin user di table
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),

                Tables\Actions\BulkAction::make('assignCategories')
                    ->label('Assign Categories')
                    ->icon('heroicon-o-tag')
                    ->form([
                        Forms\Components\MultiSelect::make('categories')
                            ->label('Select Categories')
                            ->options(
                                \App\Models\Category::query()
                                    ->where('business_id', $this->getOwnerRecord()->id)
                                    ->pluck('name', 'id')
                            )
                            ->required(),
                    ])
                    ->action(function (array $data, $records): void {
                        foreach ($records as $product) {
                            // Attach categories ke masing-masing product
                            $product->categories()->syncWithoutDetaching($data['categories']);
                        }
                    })
                    ->deselectRecordsAfterCompletion(), // otomatis uncheck setelah selesai
            ]);
    }
}
