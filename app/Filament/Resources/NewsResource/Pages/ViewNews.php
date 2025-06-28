<?php

namespace App\Filament\Resources\NewsResource\Pages;

use Filament\Resources\Pages\ViewRecord; // Imports the base class for viewing a single record
use App\Filament\Resources\NewsResource; // Import the main NewsResource class

// This class defines the "View News Article" page in the Filament admin panel.
// Its primary purpose is to display a single news article's details (like its title, content, and image)
// in a read-only format to the user.
class ViewNews extends ViewRecord
{
    // Specifies the Filament resource that this page is associated with.
    // This is crucial as it tells Filament to use the form schema defined in
    // 'NewsResource' (specifically its `form()` method) to automatically
    // render all the details of the specific news record being viewed.
    protected static string $resource = NewsResource::class;

    // No additional methods or custom logic are typically defined within this class.
    // This is because the parent class, `ViewRecord`, provides all the default
    // functionality required to fetch a record and display its details based on
    // the associated resource's form definition. Filament handles the heavy lifting
    // of rendering the fields as read-only and retrieving the data from the database.
}
