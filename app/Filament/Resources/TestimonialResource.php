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

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

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
                // Relasi user_id ke tabel users
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name') // Pastikan relasi `user()` ada di model Testimonial
                    ->searchable()
                    ->preload()
                    ->required(),

                // Relasi ke bisnis
                Select::make('business_id')
                    ->label('Business')
                    ->relationship('business', 'name') // Pastikan relasi `business()` ada di model Testimonial
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5),

                TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->maxLength(255),

                TextInput::make('image_url_product')
                    ->label('Product Image URL')
                    ->url()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('business.name')
                    ->label('Business')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
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
