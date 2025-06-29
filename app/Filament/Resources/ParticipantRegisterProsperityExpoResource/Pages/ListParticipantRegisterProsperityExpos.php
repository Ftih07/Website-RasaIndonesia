<?php

namespace App\Filament\Resources\ParticipantRegisterProsperityExpoResource\Pages;

use App\Filament\Resources\ParticipantRegisterProsperityExpoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParticipantRegisterProsperityExpos extends ListRecords
{
    protected static string $resource = ParticipantRegisterProsperityExpoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
