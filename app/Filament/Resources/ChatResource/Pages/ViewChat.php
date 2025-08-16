<?php

namespace App\Filament\Resources\ChatResource\Pages;

use App\Filament\Resources\ChatResource;
use App\Filament\Widgets\ChatMessagesWidget;
use Filament\Resources\Pages\ViewRecord;

class ViewChat extends ViewRecord
{
    protected static string $resource = ChatResource::class;

    protected function getHeaderWidgets(): array
    {
        // Lempar $this->record ke widget
        return [
            ChatMessagesWidget::make(['record' => $this->record]),
        ];
    }
}
