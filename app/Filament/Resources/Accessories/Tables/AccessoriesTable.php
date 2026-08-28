<?php

namespace App\Filament\Resources\Accessories\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AccessoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                ImageColumn::make('image')
                    ->toggleable()
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('price')
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
                TernaryFilter::make('is_active')
                    ->label('Active'),
            ]);
    }
}
