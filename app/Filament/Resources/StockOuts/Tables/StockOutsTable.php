<?php

namespace App\Filament\Resources\StockOuts\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StockOutsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
            ->columns([
                TextColumn::make('inventoryItem.name')
                    ->label('Item')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('inventoryItem.sku')
                    ->label('SKU')
                    ->color('gray')
                    ->toggleable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('danger')
                    ->formatStateUsing(fn (string $state) => '-' . number_format((float) $state, 0)),
                TextColumn::make('reason')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('customizationRequest.request_number')
                    ->label('Customization')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('inventory_item_id')
                    ->label('Item')
                    ->relationship('inventoryItem', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('reason')
                    ->label('Reason')
                    ->options([
                        'Production' => 'Production',
                        'Damage' => 'Damage',
                        'Loss' => 'Loss',
                        'Sale' => 'Sale',
                        'Other' => 'Other',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
