<?php

namespace App\Filament\Resources\Materials\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('additional_price')
                    ->label('Additional Price')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('inventoryItem.name')
                    ->label('Inventory Item')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('inventoryItem.current_stock')
                    ->label('Stock')
                    ->numeric()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->toggleable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ]);
    }
}
