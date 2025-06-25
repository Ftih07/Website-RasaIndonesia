<?php

namespace App\Filament\Resources\TestimonialUserResource\Pages;

use App\Filament\Resources\TestimonialUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestimonialUser extends EditRecord
{
    protected static string $resource = TestimonialUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
