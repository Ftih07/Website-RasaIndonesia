<?php

namespace App\Filament\Resources\BusinessResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;

class ProductOptionGroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'productOptionGroups'; // relasi di model Business

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Group Name')
                    ->required(),
                Forms\Components\Toggle::make('is_required')
                    ->label('Is Required?'),
                Forms\Components\TextInput::make('max_selection')
                    ->label('Max Selection')
                    ->numeric()
                    ->required(),

                // Nested repeater options langsung di dalam form edit group
                Forms\Components\Repeater::make('options')
                    ->relationship('options') // relasi group -> options
                    ->collapsed() // default collapse untuk option
                    ->cloneable() // tombol duplicate untuk option
                    ->itemLabel(fn(array $state): string => $state['name'] ?? 'New Option')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Additional Price')
                            ->numeric()
                            ->prefix('+ $')
                            ->default(0),
                    ]),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Group Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_required')
                    ->label('Required'),
                Tables\Columns\TextColumn::make('max_selection')
                    ->label('Max Selection'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\ReplicateAction::make()
                    ->label('Duplicate')
                    ->afterReplicaSaved(function ($replica, $record) {
                        foreach ($record->options as $option) {
                            $replica->options()->create([
                                'name'  => $option->name,
                                'price' => $option->price,
                            ]);
                        }
                    }),
            ]);
    }
}
