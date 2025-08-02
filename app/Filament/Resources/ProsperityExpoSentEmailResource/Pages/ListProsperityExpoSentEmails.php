<?php

namespace App\Filament\Resources\ProsperityExpoSentEmailResource\Pages;

use App\Filament\Resources\ProsperityExpoSentEmailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProsperityExpoSentEmails extends ListRecords
{
    protected static string $resource = ProsperityExpoSentEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
