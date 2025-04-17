<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewScrapperResource\Pages;
use App\Models\ReviewScrapper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReviewScrapperResource extends Resource
{
    protected static ?string $model = ReviewScrapper::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'Review Scrapper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Google Maps Scraper')
                    ->schema([
                        Forms\Components\TextInput::make('maps_url')
                            ->label('Google Maps URL')
                            ->required()
                            ->url()
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),
                Forms\Components\Section::make('Scraped Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('rating')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('reviews')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('additional_data')
                            ->label('Additional Data')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->url(fn($record) => $record->website)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('rating')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('scrape')
                    ->label('Scrape Data')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (ReviewScrapper $record) {
                        app(\App\Services\GoogleMapsScraper::class)->scrapeFromUrl($record->maps_url);
                    }),
                Tables\Actions\Action::make('download_json')
                    ->label('Download JSON')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (ReviewScrapper $record) {
                        $data = [
                            'id' => $record->id,
                            'name' => $record->name,
                            'address' => $record->address,
                            'phone' => $record->phone,
                            'website' => $record->website,
                            'rating' => $record->rating,
                            'reviews' => $record->reviews,
                            'maps_url' => $record->maps_url,
                            'additional_data' => $record->additional_data,
                            'created_at' => $record->created_at,
                            'updated_at' => $record->updated_at,
                        ];

                        $filename = Str::slug($record->name) . '-' . date('Y-m-d') . '.json';
                        $path = 'downloads/' . $filename;

                        if (!Storage::exists('downloads')) {
                            Storage::makeDirectory('downloads');
                        }

                        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

                        return Storage::download($path, $filename);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('download_selected_json')
                        ->label('Download Selected as JSON')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function ($records) {
                            $data = [];

                            foreach ($records as $record) {
                                $data[] = [
                                    'id' => $record->id,
                                    'name' => $record->name,
                                    'address' => $record->address,
                                    'phone' => $record->phone,
                                    'website' => $record->website,
                                    'rating' => $record->rating,
                                    'reviews' => $record->reviews,
                                    'maps_url' => $record->maps_url,
                                    'additional_data' => $record->additional_data,
                                    'created_at' => $record->created_at,
                                    'updated_at' => $record->updated_at,
                                ];
                            }

                            $filename = 'review-scrapper-export-' . date('Y-m-d') . '.json';
                            $path = 'downloads/' . $filename;

                            if (!Storage::exists('downloads')) {
                                Storage::makeDirectory('downloads');
                            }

                            Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

                            return Storage::download($path, $filename);
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
            'index' => Pages\ListReviewScrappers::route('/'),
            'create' => Pages\CreateReviewScrapper::route('/create'),
            'edit' => Pages\EditReviewScrapper::route('/{record}/edit'),
        ];
    }
}
