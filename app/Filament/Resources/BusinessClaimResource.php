<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessClaimResource\Pages;
use App\Filament\Resources\BusinessClaimResource\RelationManagers;
use App\Models\BusinessClaim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BusinessClaimResource extends Resource
{
    protected static ?string $model = BusinessClaim::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Business Claim';

    protected static ?string $navigationGroup = 'Business Management';
    protected static ?int $navigationSort = 100;
    protected static ?string $slug = 'business-claim';

    public static function getNavigationBadge(): ?string
    {
        return BusinessClaim::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('user.contact')->label('Contact'),
                Tables\Columns\TextColumn::make('user.address')->label('Address'),
                Tables\Columns\TextColumn::make('business.name')->label('Bisnis'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('Approve')
                    ->action(function (BusinessClaim $record) {
                        if (!$record->user->business && !$record->business->user_id) {
                            $record->business->user_id = $record->user_id;
                            $record->business->save();

                            $record->user->assignRole('seller');

                            // Kirim notifikasi ke user
                            \App\Helpers\NotificationHelper::send(
                                $record->user_id,
                                'Klaim bisnis disetujui',
                                'Selamat! Klaim bisnis "' . $record->business->name . '" telah disetujui.',
                                route('dashboard')
                            );

                            $record->delete(); // Hapus klaim setelah disetujui

                            \Filament\Notifications\Notification::make()
                                ->title('Klaim disetujui dan bisnis berhasil ditransfer ke user.')
                                ->success()
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Gagal menyetujui klaim.')
                                ->body('User sudah memiliki bisnis atau bisnis sudah diklaim.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn(BusinessClaim $record) => $record->status === 'pending'),


                Tables\Actions\Action::make('Reject')
                    ->action(function (BusinessClaim $record) {
                        $userId = $record->user_id;
                        $businessName = $record->business->name;

                        $record->delete(); // Observer juga bisa jalan jika kamu pakai

                        // Kirim notifikasi ke user bahwa klaimnya ditolak
                        \App\Helpers\NotificationHelper::send(
                            $userId,
                            'Klaim bisnis kamu ditolak',
                            'Klaim atas bisnis "' . $businessName . '" telah ditolak oleh admin.',
                            route('dashboard')
                        );

                        // Notifikasi ke admin (Filament)
                        \Filament\Notifications\Notification::make()
                            ->title('Klaim bisnis ditolak dan dihapus.')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn(BusinessClaim $record) => $record->status === 'pending'),
            ]);
    }


    public static function approveClaim(BusinessClaim $claim)
    {
        if (!$claim->user->business && !$claim->business->user_id) {
            $claim->business->user_id = $claim->user_id;
            $claim->business->save();

            $claim->user->assignRole('seller');
            $claim->status = 'approved';
            $claim->save();
        }
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
            'index' => Pages\ListBusinessClaims::route('/'),
        ];
    }
}
