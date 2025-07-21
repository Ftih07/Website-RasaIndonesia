<?php

namespace App\Filament\Resources;

use App\Models\Business;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Resources\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table as TablesTable;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class BusinessApprovalResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Business Management';
    protected static ?string $navigationLabel = 'Business Approvals';
    protected static ?int $navigationSort = 100;
    protected static ?string $slug = 'business-approvals';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Business Name')
                ->disabled(),

            TextInput::make('type.title')
                ->label('Business Type')
                ->disabled(),

            Textarea::make('description')
                ->label('Description')
                ->disabled(),

            TextInput::make('country')
                ->disabled(),

            TextInput::make('city')
                ->disabled(),

            Textarea::make('address')
                ->label('Full Address')
                ->disabled(),

            TextInput::make('location')
                ->label('Google Maps Link')
                ->disabled(),

            Toggle::make('is_verified')
                ->label('Approve this business')
                ->onIcon('heroicon-o-check-circle')
                ->offIcon('heroicon-o-x-circle'),
        ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->query(Business::query()->where('is_verified', false))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Business Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type.title')
                    ->label('Business Type'),

                Tables\Columns\TextColumn::make('city')
                    ->sortable(),

                Tables\Columns\TextColumn::make('country'),

                Tables\Columns\BooleanColumn::make('is_verified')
                    ->label('Verified'),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                Action::make('Approve')
                    ->action(function (Business $record) {
                        // Set bisnis menjadi verified
                        $record->update(['is_verified' => true]);

                        // Tambahkan role seller kalau belum
                        if ($record->user && !$record->user->hasRole('seller')) {
                            $record->user->assignRole('seller');
                        }

                        // Kirim notifikasi ke user
                        if ($record->user_id) {
                            \App\Helpers\NotificationHelper::send(
                                $record->user_id,
                                'Bisnis kamu telah disetujui',
                                'Selamat! Bisnis "' . $record->name . '" telah disetujui dan akan ditampilkan ke publik.',
                                route('dashboard')
                            );
                        }

                        // Notifikasi admin di Filament
                        Notification::make()
                            ->title('Bisnis berhasil disetujui.')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn(Business $record) => !$record->is_verified),
                Action::make('Reject')
                    ->form([
                        Textarea::make('reason')
                            ->label('Alasan Penolakan')
                            ->required(),
                    ])
                    ->action(function (Business $record, array $data) {
                        $userId = $record->user_id;
                        $businessName = $record->name;

                        $record->delete();

                        if ($userId) {
                            \App\Helpers\NotificationHelper::send(
                                $userId,
                                'Bisnis kamu ditolak',
                                'Bisnis "' . $businessName . '" ditolak. Alasan: ' . $data['reason'],
                                route('dashboard')
                            );
                        }

                        Notification::make()
                            ->title('Bisnis ditolak dan dihapus.')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn(Business $record) => !$record->is_verified),

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\BusinessApprovalResource\Pages\ListBusinessApprovals::route('/'),
            'edit' => \App\Filament\Resources\BusinessApprovalResource\Pages\EditBusinessApproval::route('/{record}/edit'),
        ];
    }
}
