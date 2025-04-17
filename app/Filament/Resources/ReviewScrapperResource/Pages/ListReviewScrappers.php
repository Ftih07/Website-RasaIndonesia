<?php

namespace App\Filament\Resources\ReviewScrapperResource\Pages;

use App\Filament\Resources\ReviewScrapperResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReviewScrappers extends ListRecords
{
    protected static string $resource = ReviewScrapperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
