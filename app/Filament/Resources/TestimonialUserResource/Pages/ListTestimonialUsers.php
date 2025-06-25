<?php

namespace App\Filament\Resources\TestimonialUserResource\Pages;

use App\Filament\Resources\TestimonialUserResource;
use Filament\Resources\Pages\ListRecords;

/**
 * This class defines the "List Testimonial Users" page within the Filament admin panel.
 * It extends Filament's base ListRecords page, providing a view for listing TestimonialUser records.
 */
class ListTestimonialUsers extends ListRecords
{
    /**
     * Specifies the Filament Resource associated with this page.
     * This links the page to the TestimonialUserResource, allowing it to display data from the TestimonialUser model.
     *
     * @var string
     */
    protected static string $resource = TestimonialUserResource::class;

    /**
     * Defines the header actions for this page.
     * By returning an empty array, it effectively disables any default header actions,
     * such as the "Create" button, which prevents users from creating new records directly from this list page.
     *
     * @return array An array of Filament Actions.
     */
    protected function getHeaderActions(): array
    {
        // Returns an empty array to remove all header actions, including the "Create" button.
        return [];
    }
}
