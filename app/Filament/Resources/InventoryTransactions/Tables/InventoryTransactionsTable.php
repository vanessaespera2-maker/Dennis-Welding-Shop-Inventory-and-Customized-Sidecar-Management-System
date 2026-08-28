<?php

namespace App\Filament\Resources\InventoryTransactions\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class InventoryTransactionsTable
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
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'stock_in' => 'success',
                        'stock_out' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'stock_in' => 'Stock In',
                        'stock_out' => 'Stock Out',
                        default => 'Adjustment',
                    }),
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn (string $state, $record): string => $record->type === 'stock_out'
                        ? '-' . number_format((float) $state, 2)
                        : number_format((float) $state, 2)),
                TextColumn::make('previous_stock')
                    ->label('Before')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('new_stock')
                    ->label('After')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('reason')
                    ->searchable()
                    ->wrap()
                    ->limit(40),
                TextColumn::make('reference_number')
                    ->label('Reference')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'stock_in' => 'Stock In',
                        'stock_out' => 'Stock Out',
                        'adjustment' => 'Adjustment',
                    ]),
                SelectFilter::make('inventory_item_id')
                    ->label('Item')
                    ->relationship('inventoryItem', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('user_id')
                    ->label('Has User')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('user_id'),
                        false: fn ($query) => $query->whereNull('user_id'),
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
