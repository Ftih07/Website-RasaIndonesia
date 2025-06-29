<?php

namespace App\Filament\Pages;

use Filament\Pages\Page; // Imports the base class for creating custom Filament pages

// This class defines a custom page within the Filament admin panel.
// Unlike Resources, which are tied directly to Eloquent models for CRUD operations,
// custom pages allow you to build any kind of custom interface or dashboard.
class EventCheckIn extends Page
{
    // Defines the Heroicon to be used as the navigation icon for this custom page
    // in the Filament sidebar. 'heroicon-o-qr-code' will display a QR code icon.
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    // Specifies the Blade view file that will be rendered when this page is accessed.
    // This view (located at 'resources/views/filament/pages/event-check-in.blade.php')
    // will contain the actual HTML and logic for your QR code check-in interface.
    protected static string $view = 'filament.pages.event-check-in';

    // Sets the label that will appear in the Filament sidebar navigation for this page.
    // Users will see 'QR Check-In' in the menu.
    protected static ?string $navigationLabel = 'QR Check-In';

    // Organizes this custom page under a specific group in the Filament sidebar navigation.
    // This helps in structuring the navigation menu, especially with many pages or resources.
    protected static ?string $navigationGroup = 'Event Management';

    // You can add methods here to define properties or logic specific to this custom page,
    // such as handling form submissions, fetching data, or interacting with other components
    // within the 'filament.pages.event-check-in' Blade view.
}
