<?php

namespace App\Filament\Resources\StockIns\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StockInsTable
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
                    ->color('success')
                    ->formatStateUsing(fn (string $state) => '+' . number_format((float) $state, 0)),
                TextColumn::make('unit_cost')
                    ->label('Unit Cost')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('total_cost')
                    ->label('Total Cost')
                    ->money('PHP')
                    ->getStateUsing(fn ($record): float => (float) $record->quantity * (float) $record->unit_cost)
                    ->sortable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reference_number')
                    ->label('Ref No.')
                    ->searchable()
                    ->color('gray')
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
                SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
