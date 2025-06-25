<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialUserResource\Pages;
use App\Models\TestimonialUser;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Defines the FilamentPHP resource for managing TestimonialUser models.
 * This resource primarily provides a read-only view of testimonial user data.
 */
class TestimonialUserResource extends Resource
{
    // The Eloquent model associated with this Filament resource.
    protected static ?string $model = TestimonialUser::class;

    // The label displayed in the Filament sidebar navigation.
    protected static ?string $navigationLabel = 'Testimonial Users';

    // The Heroicon icon displayed next to the navigation label in the sidebar.
    protected static ?string $navigationIcon = 'heroicon-o-users';

    // The singular name of the resource, used in various UI elements (e.g., page titles).
    protected static ?string $label = 'Testimonial User';

    // (Optional) The navigation group this resource belongs to in the sidebar.
    // This helps organize resources under a common heading.
    protected static ?string $navigationGroup = 'Testimonial Management';

    /**
     * Defines the table structure for the resource's index page.
     * This method specifies which columns to display and how they behave.
     *
     * @param Table $table The table instance to configure.
     * @return Table The configured table instance.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Displays the 'id' column, allowing it to be sortable.
                Tables\Columns\TextColumn::make('id')->sortable(),
                // Displays the 'username' column, making it searchable.
                Tables\Columns\TextColumn::make('username')->searchable(),
                // Displays the 'profile_picture' as a circular image.
                Tables\Columns\ImageColumn::make('profile_picture')->circular(),
                // Displays the 'created_at' timestamp, formatted as date and time, and sortable.
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            // Sets the default sorting order for the table by 'created_at' in descending order.
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Defines the pages accessible for this resource.
     * In this case, only the 'ListTestimonialUsers' page is registered,
     * effectively making the resource read-only (no create/edit forms).
     *
     * @return array An array of page routes.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonialUsers::route('/'),
        ];
    }

    /**
     * Determines whether this resource should be registered in the Filament navigation.
     * Returning `true` ensures it appears in the sidebar.
     *
     * @return bool True if the resource should be registered in navigation, false otherwise.
     */
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
