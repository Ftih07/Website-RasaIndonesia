<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $pluralModelLabel = 'Orders';
    protected static ?string $modelLabel = 'Order';
    protected static ?int $navigationSort = 1;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Order Details')->schema([
                    TextInput::make('order_number')
                        ->disabled()
                        ->label('Order Number'),

                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->disabled()
                        ->label('Customer'),

                    Select::make('business_id')
                        ->relationship('business', 'name')
                        ->disabled()
                        ->label('Business'),

                    Select::make('payment_id')
                        ->relationship('payment', 'id')
                        ->disabled()
                        ->label('Payment ID'),

                    TextInput::make('subtotal')
                        ->disabled()
                        ->prefix('AUD'),

                    TextInput::make('tax')
                        ->disabled()
                        ->prefix('AUD'),

                    TextInput::make('delivery_fee')
                        ->disabled()
                        ->prefix('AUD'),

                    TextInput::make('order_fee')
                        ->disabled()
                        ->prefix('AUD'),

                    TextInput::make('total_price')
                        ->disabled()
                        ->prefix('AUD'),
                ])->columns(2),

                Section::make('Shipping Info')->schema([
                    Textarea::make('shipping_address')
                        ->label('Shipping Address')
                        ->rows(3)
                        ->disabled(),

                    TextInput::make('delivery_note')
                        ->disabled(),

                    Select::make('delivery_option')
                        ->options([
                            'pickup' => 'Pickup',
                            'delivery' => 'Delivery',
                        ])
                        ->disabled(),

                    ToggleButtons::make('delivery_status')
                        ->options([
                            'waiting' => 'Waiting',
                            'confirmed' => 'Confirmed',
                            'assigned' => 'Assigned',
                            'on_delivery' => 'On Delivery',
                            'delivered' => 'Delivered',
                            'canceled' => 'Canceled',
                        ])
                        ->colors([
                            'waiting' => 'warning',
                            'confirmed' => 'info',
                            'assigned' => 'info',
                            'on_delivery' => 'primary',
                            'delivered' => 'success',
                            'canceled' => 'danger',
                        ])
                        ->inline()
                        ->label('Delivery Status'),
                ])->columns(2),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('business.name')
                    ->label('Business')
                    ->searchable(),

                BadgeColumn::make('delivery_status')
                    ->colors([
                        'waiting' => 'warning',
                        'confirmed' => 'info',
                        'assigned' => 'info',
                        'on_delivery' => 'primary',
                        'delivered' => 'success',
                        'canceled' => 'danger',
                    ])
                    ->sortable(),

                TextColumn::make('total_price')
                    ->money('AUD')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('delivery_status')
                    ->options([
                        'waiting' => 'Waiting',
                        'confirmed' => 'Confirmed',
                        'on_delivery' => 'On Delivery',
                        'delivered' => 'Delivered',
                        'assigned' => 'Assigned',
                        'canceled' => 'Canceled',
                    ]),

                SelectFilter::make('business_id')
                    ->relationship('business', 'name')
                    ->label('Business'),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                // Confirm Payment
                Tables\Actions\Action::make('confirmPayment')
                    ->label('Confirm Payment')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Order $record) {
                        try {
                            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                            $paymentIntent = \Stripe\PaymentIntent::retrieve($record->payment->transaction_id);
                            $paymentIntent->capture();

                            $record->payment->update(['status' => 'paid']);
                            $record->update(['delivery_status' => 'confirmed']);

                            Notification::make()
                                ->title('Payment confirmed successfully!')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Failed to confirm payment')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn(Order $record) => $record->payment->status === 'pending'),

                // Cancel Payment
                Tables\Actions\Action::make('cancelPayment')
                    ->label('Cancel Payment')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Order $record) {
                        try {
                            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                            $paymentIntent = \Stripe\PaymentIntent::retrieve($record->payment->transaction_id);
                            $paymentIntent->cancel();

                            $record->payment->update(['status' => 'failed']);
                            $record->update(['delivery_status' => 'canceled']);

                            Notification::make()
                                ->title('Payment canceled successfully!')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Failed to cancel payment')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn(Order $record) => $record->payment->status === 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
