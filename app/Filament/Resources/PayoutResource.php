<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayoutResource\Pages;
use App\Models\Payout;
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;

class PayoutResource extends Resource
{
    protected static ?string $model = Payout::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Reports';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('business_id')
                ->label('Business')
                ->options(Business::pluck('name', 'id'))
                ->searchable()
                ->required(),

            TextInput::make('amount')
                ->numeric()
                ->prefix('AUD')
                ->required(),

            Textarea::make('description'),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                ])
                ->default('pending')
                ->required(),

            DatePicker::make('payout_date')
                ->default(now())
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business.name')->label('Business'),
                Tables\Columns\TextColumn::make('amount')->money('AUD'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                    ]),
                Tables\Columns\TextColumn::make('payout_date')->date(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->form([
                        DatePicker::make('from')->label('From date')->native(false),
                        DatePicker::make('to')->label('To date')->native(false),
                    ])
                    ->action(function (array $data) {
                        $params = [];

                        if (!empty($data['from'])) {
                            $params['from'] = \Illuminate\Support\Carbon::parse($data['from'])->format('Y-m-d');
                        }
                        if (!empty($data['to'])) {
                            $params['to'] = \Illuminate\Support\Carbon::parse($data['to'])->format('Y-m-d');
                        }

                        return redirect()->route('export.payouts', $params);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayouts::route('/'),
            'create' => Pages\CreatePayout::route('/create'),
            'edit' => Pages\EditPayout::route('/{record}/edit'),
        ];
    }
}
