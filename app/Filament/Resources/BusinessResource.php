<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers;
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type_id')
                    ->label('Type Business')
                    ->relationship('type', 'title')
                    ->required(),

                Forms\Components\Select::make('food_categories')
                    ->label('Food Categories in Business')
                    ->relationship('food_categories', 'title') // Menggunakan relasi many-to-many
                    ->multiple() // Mendukung multi-select
                    ->required(),


                Forms\Components\TextInput::make('name')
                    ->label('Business Name')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Business Description')
                    ->required(),

                Forms\Components\FileUpload::make('logo')
                    ->label('Logo')
                    ->directory('logos'),

                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->required(),

                Forms\Components\KeyValue::make('open_hours')
                    ->label('Open Hours')
                    ->keyLabel('Day')
                    ->valueLabel('Hours')
                    ->required(),

                Forms\Components\CheckboxList::make('services')
                    ->label('Services')
                    ->options([
                        'Makan Di Tempat' => 'Makan Di Tempat',
                        'Delivery' => 'Delivery',
                    ])
                    ->required(),

                Forms\Components\FileUpload::make('menu')
                    ->label('Menu List')
                    ->directory('menu'),

                Forms\Components\Repeater::make('media_social')
                    ->label('Social Media')
                    ->schema([
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'website' => 'Website',
                                'instagram' => 'Instagram',
                                'facebook' => 'Facebook',
                                'twitter' => 'Twitter',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('link')
                            ->label('Link')
                            ->url()
                            ->required(),
                    ])
                    ->columns(2)
                    ->required(),

                Forms\Components\TextInput::make('location')
                    ->label('Business Location'),

                Forms\Components\TextInput::make('iframe_url')
                    ->label('Iframe Business Location')
                    ->maxLength(2048) // Mengatur panjang maksimum karakter
                    ->required(), // Opsional

                Forms\Components\Repeater::make('contact')
                    ->label('Contact')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Contact Type')
                            ->options([
                                'email' => 'Email',
                                'wa' => 'WhatsApp',
                                'telp' => 'Telephone',
                                'telegram' => 'Telegram',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('details')
                            ->label('Link or Number Contact')
                            ->required(),
                    ])
                    ->columns(2) // Untuk tata letak form
                    ->required(),


                // Gallery Business Form
                Forms\Components\Repeater::make('galleries')
                    ->label('Gallery')
                    ->relationship('galleries')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Gallery Title')
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->directory('gallery-images')
                            ->required(),
                    ])
                    ->columns(1),

                // Product Business Form
                Forms\Components\Repeater::make('products')
                    ->label('Products')
                    ->relationship('products')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Product Name')
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->label('Product Image')
                            ->directory('product-images')
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options([
                                'makanan' => 'Makanan',
                                'minuman' => 'Minuman',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('serving')
                            ->label('Serving'),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('address')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
