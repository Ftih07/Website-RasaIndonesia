<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Users';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(', ')
                    ->colors([
                        'primary' => 'customer',
                        'success' => 'seller',
                        'warning' => 'partner',
                        'danger' => 'admin',
                        'gray' => 'superadmin',
                        'purple' => 'courier',
                    ]),
            ])
            ->filters([])
            ->actions([
                Action::make('setPartner')
                    ->label('Assign Partner')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(
                        fn(User $record) =>
                        $record->hasRole('customer') &&
                            ! $record->hasRole('seller') &&
                            ! $record->hasRole('partner')
                    )
                    ->action(function (User $record) {
                        $record->removeRole('customer');
                        $record->addRole('partner');
                    }),

                Action::make('removePartner')
                    ->label('Remove Partner')
                    ->icon('heroicon-o-user-minus')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(User $record) => $record->hasRole('partner'))
                    ->action(function (User $record) {
                        $record->removeRole('partner');
                        $record->addRole('customer'); // opsional
                    }),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
