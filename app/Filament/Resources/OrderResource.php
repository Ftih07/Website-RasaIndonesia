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
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use App\Models\Chat;
use App\Models\User;
use App\Services\ChatService;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $pluralModelLabel = 'Orders';
    protected static ?string $modelLabel = 'Order';
    protected static ?int $navigationSort = 1;

    // 🔹 Method filter query
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('payment', function ($q) {
                $q->where('status', '!=', 'incomplete');
            });
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('partner_id')
                    ->label('Assign Partner')
                    ->relationship('partner', 'name') // pastikan relasi di model Order: partner()
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->disabled(true),

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

                    TextInput::make('gross_price')
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
                        ->label('Delivery Status')
                        ->afterStateUpdated(function ($state, $record) {
                            $superadminId = 2; // sesuaikan ID superadmin
                            $statusText = ucfirst(str_replace('_', ' ', $state));

                            // === 1. Kirim ke customer ===
                            if ($record->user_id) {
                                $chatCustomer = ChatService::getOrCreateChat($superadminId, $record->user_id);

                                ChatService::sendMessage(
                                    $chatCustomer->id,
                                    $superadminId,
                                    "Order #{$record->id} status diperbarui menjadi: {$statusText}",
                                    'system'
                                );
                                $chatCustomer->touch();

                                // 🚀 Tambah notifikasi ke customer
                                \App\Helpers\NotificationHelper::send(
                                    $record->user_id,
                                    'Update Pesanan',
                                    "Order #{$record->id} status diperbarui menjadi: {$statusText}",
                                    route('orders.index', $record->id) // kalau ada detail order
                                );
                            }

                            // === 2. Kirim ke partner (jika ada) ===
                            if ($record->partner_id) {
                                $chatPartner = ChatService::getOrCreateChat($superadminId, $record->partner_id);

                                ChatService::sendMessage(
                                    $chatPartner->id,
                                    $superadminId,
                                    "Order #{$record->id} status diperbarui menjadi: {$statusText}",
                                    'system'
                                );
                                $chatPartner->touch();

                                // 🚀 Tambah notifikasi ke partner
                                \App\Helpers\NotificationHelper::send(
                                    $record->partner_id,
                                    'Update Pesanan',
                                    "Order #{$record->id} status diperbarui menjadi: {$statusText}",
                                    route('orders.index', $record->id)
                                );
                            }
                        }),

                ])->columns(2),

                Section::make('Order Items')->schema([
                    Repeater::make('items')
                        ->relationship('items')
                        ->schema([
                            TextInput::make('product_name')
                                ->label('Product')
                                ->disabled()
                                ->afterStateHydrated(function ($component, $state, $record) {
                                    if ($record && $record->product) {
                                        $component->state($record->product->name);
                                    }
                                }),

                            Textarea::make('options')
                                ->label('Options')
                                ->disabled()
                                ->formatStateUsing(function ($state, $record) {
                                    $html = '';
                                    $options = is_string($record->options) ? json_decode($record->options, true) : $record->options;
                                    if (!empty($options)) {
                                        foreach ($options as $group) {
                                            if (!empty($group['selected'])) {
                                                foreach ($group['selected'] as $selected) {
                                                    $option = \App\Models\ProductOption::find($selected['id']);
                                                    if ($option) {
                                                        $price = $selected['price'] ?? $option->price;
                                                        $html .= "{$group['group_name']} - {$option->name} (+A$" . number_format($price, 2) . ")\n";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    return $html;
                                })
                                ->rows(3),

                            TextInput::make('preference_if_unavailable')
                                ->label('Preference if Unavailable')
                                ->disabled(),

                            TextInput::make('note')
                                ->label('Note')
                                ->disabled(),

                            TextInput::make('quantity')
                                ->label('Quantity')
                                ->disabled(),

                            TextInput::make('unit_price')
                                ->label('Unit Price')
                                ->prefix('A$')
                                ->disabled(),

                            TextInput::make('total_price')
                                ->label('Total Price')
                                ->prefix('A$')
                                ->disabled(),
                        ])
                        ->columns(1)
                        ->disableItemCreation()
                        ->disableItemDeletion(),
                ])->columns(1),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('partner.name')->label('Partner'),

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

                TextColumn::make('gross_price')
                    ->money('AUD')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('items')
                    ->label('Products & Options')
                    ->formatStateUsing(function ($record) {
                        $html = '';

                        foreach ($record->items as $item) {
                            $html .= "<strong>{$item->product->name}</strong> ({$item->quantity} × A$" . number_format($item->unit_price, 2) . ")<br>";

                            // Jika ada options, tampilkan
                            if (!empty($item->options)) {
                                // Decode options
                                $options = is_string($item->options) ? json_decode($item->options, true) : $item->options;
                                foreach ($options as $group) {
                                    if (!empty($group['selected'])) {
                                        foreach ($group['selected'] as $selected) {
                                            $option = \App\Models\ProductOption::find($selected['id']);
                                            if ($option) {
                                                $price = $selected['price'] ?? $option->price;
                                                $html .= "- {$option->name} (+A$" . number_format($price, 2) . ")<br>";
                                            }
                                        }
                                    }
                                }
                            }
                            $html .= "<hr style='margin:4px 0'>";
                        }

                        return $html;
                    })
                    ->html() // Penting, agar HTML tampil di table
                    ->sortable(false),
                Tables\Columns\TextColumn::make('shipping_address')
                    ->label('Alamat')
                    ->url(fn($record) => "https://www.google.com/maps/search/?api=1&query=" . urlencode($record->shipping_address))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => $state ?: '-'),

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
                Tables\Actions\Action::make('assignPartner')
                    ->label('Assign Partner')
                    ->icon('heroicon-o-user')
                    ->requiresConfirmation()
                    ->form([
                        Select::make('partner_id')
                            ->relationship(
                                'partner',
                                'name',
                                fn($query) => $query->whereHas('roles', fn($q) => $q->where('name', 'partner'))
                            )
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['partner_id' => $data['partner_id']]);

                        $partner = User::find($data['partner_id']);
                        $statusText = "Order #{$record->id} telah ditugaskan kepada Anda.";

                        // === 1 chat superadmin ↔ partner ===
                        $chat = ChatService::getOrCreateChat(2, $partner->id);

                        ChatService::sendMessage(
                            $chat->id,
                            2, // superadmin sebagai pengirim
                            $statusText,
                            'system'
                        );
                        $chat->touch();

                        Notification::make()
                            ->title('Partner assigned successfully')
                            ->success()
                            ->send();
                    })
                    ->visible(fn($record) => !$record->partner),

                Tables\Actions\Action::make('removePartner')
                    ->label('Remove Partner')
                    ->icon('heroicon-o-user')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $partner = $record->partner;
                        $record->update(['partner_id' => null]);

                        $statusText = "Anda telah dihapus dari Order #{$record->id}.";

                        // === 1 chat superadmin ↔ partner ===
                        $chat = ChatService::getOrCreateChat(2, $partner->id);

                        ChatService::sendMessage(
                            $chat->id,
                            2, // superadmin sebagai pengirim
                            $statusText,
                            'system'
                        );
                        $chat->touch();

                        Notification::make()
                            ->title('Partner removed successfully')
                            ->success()
                            ->send();
                    })
                    ->visible(fn($record) => $record->partner),

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

                            // === Trigger Chat ===
                            $businessId = $record->business_id;
                            $customerId = $record->user_id;
                            $superadminId = 2;

                            $chat = ChatService::getOrCreateChat($customerId, $superadminId, $businessId);
                            ChatService::sendMessage(
                                $chat->id,
                                $superadminId,
                                "Pesanan kamu sudah dikonfirmasi dan sedang diproses.",
                                'system'
                            );

                            // === 🚀 Notifikasi ke customer ===
                            \App\Helpers\NotificationHelper::send(
                                $customerId,
                                'Pembayaran Dikonfirmasi',
                                "Pesanan #{$record->id} sudah dikonfirmasi dan sedang diproses.",
                                route('orders.index', $record->id)
                            );

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

                            // === 🚀 Notifikasi ke customer ===
                            \App\Helpers\NotificationHelper::send(
                                $record->user_id,
                                'Pembayaran Dibatalkan',
                                "Pesanan #{$record->id} telah dibatalkan. Jika sudah ada pembayaran masuk, akan segera direfund.",
                                route('orders.index', $record->id)
                            );

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
