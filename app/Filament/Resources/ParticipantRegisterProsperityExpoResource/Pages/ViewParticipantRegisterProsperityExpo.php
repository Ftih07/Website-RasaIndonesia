<?php

namespace App\Filament\Resources\ParticipantRegisterProsperityExpoResource\Pages;

use Filament\Resources\Pages\ViewRecord; // Imports the base class for viewing a single record in Filament
use App\Filament\Resources\ParticipantRegisterProsperityExpoResource; // Imports the main Filament Resource for participants

// This class defines the "View" page for a single Participant Register record
// within the Filament admin panel.
// Its main job is to display all the details of a specific participant
// in a read-only view.
class ViewParticipantRegisterProsperityExpo extends ViewRecord
{
    // This static property tells Filament which main Resource this page belongs to.
    // By linking it to `ParticipantRegisterProsperityExpoResource::class`,
    // Filament automatically knows which model to use (ParticipantRegisterProsperityExpo)
    // and how to render the view form (using the `form()` method defined in the main Resource).
    // It essentially reuses the form fields defined in the resource, but displays them as read-only.
    protected static string $resource = ParticipantRegisterProsperityExpoResource::class;

    // In most cases, you don't need to add any custom methods here.
    // The `ViewRecord` base class already handles:
    // 1. Fetching the specific record from the database using its ID from the URL.
    // 2. Automatically displaying all the fields defined in the `form()` method of the associated Resource.
    // 3. Making these fields read-only so users can only view, not edit, the data on this page.
    // Custom logic would only be needed if you wanted to add unique actions or modify the view behavior
    // specifically for this page, beyond what the main Resource's form provides.
}
