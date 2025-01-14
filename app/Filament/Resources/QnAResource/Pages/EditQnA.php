<?php

namespace App\Filament\Resources\QnAResource\Pages;

use App\Filament\Resources\QnAResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQnA extends EditRecord
{
    protected static string $resource = QnAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
