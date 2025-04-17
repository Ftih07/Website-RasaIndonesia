<?php

namespace App\Filament\Resources\ReviewScrapperResource\Pages;

use App\Filament\Resources\ReviewScrapperResource;
use App\Services\GoogleMapsScraper;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditReviewScrapper extends EditRecord
{
    protected static string $resource = ReviewScrapperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('rescrape')
                ->label('Re-Scrape Data')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $scraper = app(GoogleMapsScraper::class);
                    $updatedRecord = $scraper->scrapeFromUrl($this->record->maps_url);

                    if (!$updatedRecord) {
                        Notification::make()
                            ->title('Re-scraping failed')
                            ->body('Could not scrape data from the provided URL.')
                            ->danger()
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->title('Re-scraping successful')
                        ->body('Data has been updated.')
                        ->success()
                        ->send();

                    $this->redirect(ReviewScrapperResource::getUrl('edit', ['record' => $updatedRecord]));
                }),
            Actions\Action::make('download_json')
                ->label('Download JSON')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $data = [
                        'id' => $this->record->id,
                        'name' => $this->record->name,
                        'address' => $this->record->address,
                        'phone' => $this->record->phone,
                        'website' => $this->record->website,
                        'rating' => $this->record->rating,
                        'reviews' => $this->record->reviews,
                        'maps_url' => $this->record->maps_url,
                        'additional_data' => $this->record->additional_data,
                        'created_at' => $this->record->created_at,
                        'updated_at' => $this->record->updated_at,
                    ];

                    $filename = \Illuminate\Support\Str::slug($this->record->name) . '-' . date('Y-m-d') . '.json';
                    $path = 'downloads/' . $filename;

                    if (!\Illuminate\Support\Facades\Storage::exists('downloads')) {
                        \Illuminate\Support\Facades\Storage::makeDirectory('downloads');
                    }

                    \Illuminate\Support\Facades\Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

                    return \Illuminate\Support\Facades\Storage::download($path, $filename);
                }),
        ];
    }
}
