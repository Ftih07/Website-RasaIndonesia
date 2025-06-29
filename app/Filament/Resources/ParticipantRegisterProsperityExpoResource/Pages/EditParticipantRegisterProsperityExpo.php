<?php

namespace App\Filament\Resources\ParticipantRegisterProsperityExpoResource\Pages;

use App\Filament\Resources\ParticipantRegisterProsperityExpoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParticipantRegisterProsperityExpo extends EditRecord
{
    protected static string $resource = ParticipantRegisterProsperityExpoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
