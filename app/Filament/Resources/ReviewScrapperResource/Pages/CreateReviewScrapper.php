<?php

namespace App\Filament\Resources\ReviewScrapperResource\Pages;

use App\Filament\Resources\ReviewScrapperResource;
use App\Models\ReviewScrapper;
use App\Services\GoogleMapsScraper;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreateReviewScrapper extends CreateRecord
{
    use HasWizard;

    protected static string $resource = ReviewScrapperResource::class;

    public function mount(): void
    {
        $this->authorizeAccess();

        $this->form->fill();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Di CreateReviewScrapper.php
    protected function getSteps(): array
    {
        return [
            Step::make('URL Input')
                ->schema([
                    TextInput::make('maps_url')
                        ->label('Google Maps URL')
                        ->required()
                        ->url()
                        ->helperText('Please enter a Google Maps business URL (e.g., https://www.google.com/maps/place/Business+Name)')
                        ->columnSpanFull(),
                ]),

            Step::make('Basic Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Business Name')
                        ->required()
                        ->default('Unnamed Business'),
                ])
                ->afterValidation(function (array $data) {
                    // Combine data from both steps
                    $formData = [
                        'name' => $data['name'],
                        'maps_url' => $this->data['maps_url'],
                    ];

                    // Create basic record first
                    $reviewScrapper = ReviewScrapper::create($formData);

                    // Then try to scrape additional data
                    $scraper = app(GoogleMapsScraper::class);
                    $scrapedData = $scraper->scrapeFromUrl($formData['maps_url']);

                    if ($scrapedData) {
                        // Update with scraped data if successful
                        $reviewScrapper->update([
                            'address' => $scrapedData->address,
                            'phone' => $scrapedData->phone,
                            'website' => $scrapedData->website,
                            'rating' => $scrapedData->rating,
                            'reviews' => $scrapedData->reviews,
                            'additional_data' => $scrapedData->additional_data,
                        ]);
                    }

                    $this->redirect(ReviewScrapperResource::getUrl('edit', ['record' => $reviewScrapper]));
                }),
        ];
    }
}
