<?php

namespace App\Filament\Resources\EventsResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\EventsResource; // Import the main EventsResource class

// This class defines the "View Event" page in the Filament admin panel.
// Its purpose is to display a single event's details in a read-only format.
class ViewEvents extends ViewRecord
{
    // Specifies the Filament resource that this page belongs to.
    // This links this 'ViewEvents' page back to the main 'EventsResource' definition,
    // allowing it to use the form schema defined in EventsResource for displaying data.
    protected static string $resource = EventsResource::class;

    // No additional methods are defined here because 'ViewRecord'
    // provides all the necessary functionality by default.
    // It automatically uses the `form()` schema from the associated resource
    // (EventsResource in this case) to render the record's details.
}
