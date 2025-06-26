<?php

namespace App\Filament\Resources\FoodCategoryResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\FoodCategoryResource; // Import the main FoodCategoryResource class

// This class defines the "View Food Category" page in the Filament admin panel.
// Its purpose is to display a single food category's details in a read-only format.
class ViewFoodCategory extends ViewRecord
{
    // Specifies the Filament resource that this page belongs to.
    // This links this 'ViewFoodCategory' page back to the main 'FoodCategoryResource' definition,
    // allowing it to use the form schema defined in FoodCategoryResource for displaying data.
    protected static string $resource = FoodCategoryResource::class;

    // No additional methods are defined here because 'ViewRecord'
    // provides all the necessary functionality by default.
    // It automatically uses the `form()` schema from the associated resource
    // (FoodCategoryResource in this case) to render the record's details.
}
