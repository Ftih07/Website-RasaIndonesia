<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('title')
                    ->label('News Title')
                    ->required(),
                Forms\Components\FileUpload::make('image_news')
                    ->label('Related News Image')
                    ->directory('image_news') // Save images in the 'gallery' directory
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg']) // Allowed file types
                    ->required(),
                Forms\Components\TextInput::make('writer')
                    ->label('News Writer')
                    ->required(),


                DateTimePicker::make('date_published')
                    ->label('Publish Time')
                    ->default(now())
                    ->timezone('Australia/Melbourne')
                    ->visible(fn($get) => $get('status') === 'published')
                    ->requiredIf('status', 'published'),

                TextInput::make('time_read')
                    ->numeric()
                    ->suffix('menit')
                    ->disabled(), // biar user nggak bisa edit  

                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required()
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state === 'published') {
                            $set('date_published', now());
                        }
                    }),


                RichEditor::make('desc')
                    ->required()
                    ->columnSpanFull(), // biar lebarnya full
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('writer'),
                TextColumn::make('time_read')
                    ->label('Time Read')
                    ->suffix(' minute'),
                TextColumn::make('date_published')
                    ->label('Date Published')
                    ->formatStateUsing(function ($state, $record) {
                        // Kalau status masih draft atau date_published null
                        if ($record->status === 'draft' || !$state) {
                            return 'Not Published';
                        }

                        $carbon = Carbon::parse($state)->timezone('Australia/Melbourne');

                        $time = $carbon->format('g:i A'); // contoh: 8:00 AM
                        $tzAbbr = $carbon->format('T');   // contoh: AEDT / AEST
                        $date = $carbon->format('D M j, Y'); // contoh: Sat Mar 22, 2025

                        return "Published {$time} {$tzAbbr} (Melbourne Time), {$date}";
                    })
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                    ])
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'draft' => 'Draft',
                            'published' => 'Published',
                            default => ucfirst($state),
                        };
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
