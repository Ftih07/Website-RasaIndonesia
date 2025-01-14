<?php

namespace App\Filament\Resources\QnAResource\Pages;

use App\Filament\Resources\QnAResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQnAS extends ListRecords
{
    protected static string $resource = QnAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
