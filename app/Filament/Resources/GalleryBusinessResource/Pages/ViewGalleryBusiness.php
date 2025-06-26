<?php

namespace App\Filament\Resources\GalleryBusinessResource\Pages;

use Filament\Resources\Pages\ViewRecord; // Imports the base class for viewing a single record
use App\Filament\Resources\GalleryBusinessResource; // Import the main GalleryBusinessResource class

// This class defines the "View Business Gallery Item" page in the Filament admin panel.
// Its primary purpose is to display a single business gallery item's details (like an image and its title)
// in a read-only format to the user.
class ViewGalleryBusiness extends ViewRecord
{
    // Specifies the Filament resource that this page is associated with.
    // This is crucial as it tells Filament to use the form schema defined in
    // 'GalleryBusinessResource' (specifically its `form()` method) to automatically
    // render all the details of the specific gallery business record being viewed.
    protected static string $resource = GalleryBusinessResource::class;

    // No additional methods or custom logic are defined within this class.
    // This is because the parent class, `ViewRecord`, provides all the default
    // functionality required to fetch a record and display its details based on
    // the associated resource's form definition. Filament handles the heavy lifting
    // of rendering the fields as read-only and retrieving the data from the database.
}
