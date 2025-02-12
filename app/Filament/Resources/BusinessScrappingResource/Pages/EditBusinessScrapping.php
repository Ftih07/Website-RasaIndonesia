<?php

namespace App\Filament\Resources\BusinessScrappingResource\Pages;

use App\Filament\Resources\BusinessScrappingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessScrapping extends EditRecord
{
    protected static string $resource = BusinessScrappingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
