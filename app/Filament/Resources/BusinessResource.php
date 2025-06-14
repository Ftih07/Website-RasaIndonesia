<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers;
use App\Http\Controllers\StickerController;
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\TrashedFilter;

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
                    ->nullable()
                    ->placeholder('Enter unique code')
                    ->columnSpan(2),

                Forms\Components\Select::make('qr_link_id')
                    ->label('QR Code')
                    ->relationship('qrLink', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Select QR code')
                    ->columnSpan(2),

                Forms\Components\Placeholder::make('qr_link_id')
                    ->content(function ($record) {
                        if (!$record || !$record->qrLink || !$record->qrLink->qr_path) {
                            return 'No QR Assigned';
                        }

                        // Tambahkan 'storage/' di depan path-nya
                        $url = asset('storage/' . $record->qrLink->qr_path);

                        return new \Illuminate\Support\HtmlString(
                            '<div style="border:1px solid #ccc;padding:10px;">'
                                . '<img src="' . $url . '" style="width:100px;" />'
                                . '<br><small>' . $url . '</small></div>'
                        );
                    })
                    ->columnSpan(2)
                    ->reactive(),

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

                // Text input for business country
                Forms\Components\TextInput::make('country')
                    ->label('Business Country'),

                // Text input for business city
                Forms\Components\TextInput::make('city')
                    ->label('Business City'),

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

                // Business Order Link
                Forms\Components\Repeater::make('order')
                    ->label('Business Order Link')
                    ->schema([
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'Menulog' => 'Menulog',
                                'DoorDash' => 'DoorDash',
                                'UberEAST' => 'UberEAST',
                                'Abacus' => 'Abacus',
                                'Fantuan' => 'Fantuan',
                                'Website' => 'Website',
                                'HungryPanda' => 'HungryPanda',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('link')
                            ->label('Link')
                            ->url(),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->nullable(), // bisa juga skip ini karena default sudah nullable
                    ])
                    ->columns(2),

                // Business Reserve Link
                Forms\Components\Repeater::make('reserve')
                    ->label('Business Reserve Link')
                    ->schema([
                        Forms\Components\Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'OpenTable' => 'OpenTable',
                                'Quandoo' => 'Quandoo',
                                'Website' => 'Website',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('link')
                            ->label('Link')
                            ->url(),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->nullable(), // bisa juga skip ini karena default sudah nullable
                    ])
                    ->columns(2),

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
                                'tiktok' => 'Tiktok',
                                'youtube' => 'Youtube',
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
                            ->directory('product-images'),

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

                        Forms\Components\Textarea::make('desc')
                            ->label('Description'),

                        Forms\Components\Repeater::make('variants')
                            ->label('Variants')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Variant Name')
                                    ->required(),
                                Forms\Components\TextInput::make('price')
                                    ->label('Variant Price')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->default([])
                            ->collapsed()
                            ->grid(2),
                    ])
                    ->columns(1),
            ]);
    }

    // Defines the table structure for displaying business records
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unique_code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type_id')
                    ->label('Type Business')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state, $record) => $record->type?->title ?? '-')
                    ->limit(20),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('address')->limit(50),
                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document')
                    ->url(fn($record) => asset('storage/' . $record->document), true)
                    ->label('Download Sticker'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])

            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(route('export-businesses'))
                    ->openUrlInNewTab()
                    ->color('success'),

                Action::make('export_all_pdf')
                    ->label('Export All Businesses PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $businesses = Business::with(['type', 'qrLink', 'galleries', 'products'])->get();

                        $pdf = Pdf::loadView('exports.businesses-pdf', [
                            'businesses' => $businesses,
                        ])->setPaper('a4', 'landscape');

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            'all-businesses.pdf'
                        );
                    }),
            ])

            ->filters([
                TrashedFilter::make(), // Menambahkan filter Trashed
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('generate_pdf')
                    ->label('Generate Sticker')
                    ->action(fn($record) => app(StickerController::class)->generate($record))
                    ->color('primary')
                    ->hidden(fn($record) => empty($record->unique_code)), // Sembunyikan kalau Unique Code kosong
                Action::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(fn($record) => route('export-business.pdf.single', $record->id))
                    ->openUrlInNewTab(),
                Tables\Actions\RestoreAction::make(),   // tombol restore
                Tables\Actions\ForceDeleteAction::make(), // tombol hapus permanen
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\RestoreBulkAction::make(),         // Restore banyak data
                    Tables\Actions\ForceDeleteBulkAction::make(),     // Hapus permanen banyak data

                    Tables\Actions\BulkAction::make('export_pdf')
                        ->label('Export PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('danger')
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $businesses = $records->load(['type', 'qrLink', 'galleries', 'products']);

                            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.businesses-pdf', [
                                'businesses' => $businesses,
                            ])->setPaper('a4', 'landscape');

                            return response()->streamDownload(
                                fn() => print($pdf->output()),
                                'bulk-businesses.pdf'
                            );
                        }),
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
