<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialResource extends Resource
{
    // Define the model associated with this resource
    protected static ?string $model = Testimonial::class;

    public static function getNavigationBadge(): ?string
    {
        return Testimonial::count(); // Menampilkan jumlah total data booking
    }

    protected static ?string $navigationGroup = 'Business Operations';
    protected static ?int $navigationSort = 2;

    // Set the navigation icon for the resource
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    /**
     * Define the form schema for creating or editing a testimonial
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Dropdown for selecting the user who provided the testimonial
                Forms\Components\Select::make('testimonial_user_id')
                    ->label('User')
                    ->relationship('testimonial_user', 'username') // Adjust based on TestimonialUser model
                    ->searchable()
                    ->preload()
                    ->required(),

                // Business ID input field
                Forms\Components\TextInput::make('business_id')
                    ->required()
                    ->numeric(),

                // Name input field
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Description text area
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                // Rating input field (numeric value)
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->columnSpanFull(), // optional: biar 1 baris penuh
            ]);
    }

    /**
     * Define the table schema for displaying testimonials
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column to display Business ID
                Tables\Columns\TextColumn::make('business_id')
                    ->numeric()
                    ->sortable(),

                // Column to display testimonial name
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                // Column to display testimonial rating
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),

                // Column to display creation date
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Column to display update date
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Define filters if needed
            ])
            ->actions([
                // Define row actions
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Define bulk actions
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Define relationships for the resource
     */
    public static function getRelations(): array
    {
        return [
            // Define relationships if needed
        ];
    }

    /**
     * Define available pages for the resource
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
