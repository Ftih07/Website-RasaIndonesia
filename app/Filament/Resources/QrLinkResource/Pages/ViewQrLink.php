<?php

namespace App\Filament\Resources\QrLinkResource\Pages;

use App\Filament\Resources\QrLinkResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewQrLink extends ViewRecord
{
    protected static string $resource = QrLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Download QR Code')
                ->url(fn () => route('qr.download', $this->record->id))
                ->openUrlInNewTab()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),
        ];
    }
}
