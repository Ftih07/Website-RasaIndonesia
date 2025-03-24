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
use Filament\Tables\Filters\SelectFilter;

// Defining a resource class for Business entity
class BusinessResource extends Resource
{
    // Specifies the Eloquent model associated with this resource
    protected static ?string $model = Business::class;

    protected static ?string $navigationGroup = 'Business';
    protected static ?int $navigationSort = 2;

    // Sets the navigation icon for the resource
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Defines the form structure for creating and editing Business records
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select field for business type with a relationship to 'type' table
                Forms\Components\Select::make('type_id')
                    ->label('Type Business')
                    ->relationship('type', 'title')
                    ->required(),
                    
                Forms\Components\TextInput::make('unique_code')
                    ->label('Unique Code')
                    ->nullable() // Tidak wajib diisi
                    ->placeholder('Enter unique code') // Menambahkan placeholder
                    ->columnSpan(2), // Jika ingin lebar input lebih besar (opsional)


                // PDF Upload Field
                Forms\Components\FileUpload::make('document')
                    ->label('Upload Sticker (PDF)')
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240), // Maksimal 10MB

                // Multi-select field for food categories related to the business
                Forms\Components\Select::make('food_categories')
                    ->label('Food Categories in Business')
                    ->relationship('food_categories', 'title') // Many-to-many relationship
                    ->multiple()
                    ->preload(),

                // Text input for business name
                Forms\Components\TextInput::make('name')
                    ->label('Business Name')
                    ->required(),

                // Textarea input for business description
                Forms\Components\Textarea::make('description')
                    ->label('Business Description'),

                // File upload input for business logo
                Forms\Components\FileUpload::make('logo')
                    ->label('Logo')
                    ->directory('logos'),

                // Textarea input for business address
                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->required(),

                // Key-value input for specifying business open hours
                Forms\Components\KeyValue::make('open_hours')
                    ->label('Open Hours')
                    ->keyLabel('Day')
                    ->valueLabel('Hours'),

                // Checkbox list for business services
                Forms\Components\CheckboxList::make('services')
                    ->label('Services')
                    ->options([
                        'Dine In' => 'Dine In',
                        'Delivery' => 'Delivery',
                    ]),

                // File upload input for menu list
                Forms\Components\FileUpload::make('menu')
                    ->label('Menu List')
                    ->directory('menu'),

                // Repeater for social media accounts
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
                    ->columns(2),

                // Text inputs for business location and Google Maps details
                Forms\Components\TextInput::make('location')
                    ->label('Google Maps Link')
                    ->required()
                    ->reactive(),

                Forms\Components\TextInput::make('latitude')
                    ->label('Latitude')
                    ->nullable()
                    ->reactive()
                    ->placeholder('Enter latitude manually'),

                Forms\Components\TextInput::make('longitude')
                    ->label('Longitude')
                    ->nullable()
                    ->reactive()
                    ->placeholder('Enter longitude manually'),

                // Text input for iframe embedding business location
                Forms\Components\TextInput::make('iframe_url')
                    ->label('Iframe Business Location')
                    ->maxLength(2048),

                // Repeater for contact details
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
                    ->columns(2),

                // Gallery section for business images
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
                                'food' => 'Food',
                                'drink' => 'Drink',
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

    // Defines the table structure for displaying business records
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('address')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('type_id')
                    ->label('Type Business')
                    ->relationship('type', 'title')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('food_categories')
                    ->label('Food Categories')
                    ->relationship('food_categories', 'title')
                    ->preload()
                    ->multiple(),
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
