<?php

namespace App\Filament\Resources\GalleryBusinessResource\Pages;

use App\Filament\Resources\GalleryBusinessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGalleryBusiness extends EditRecord
{
    protected static string $resource = GalleryBusinessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
