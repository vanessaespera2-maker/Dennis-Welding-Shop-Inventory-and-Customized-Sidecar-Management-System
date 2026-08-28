<?php

namespace App\Filament\Widgets;

use App\Models\InventoryItem;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LowStockItems extends TableWidget
{
    protected static ?int $sort = 7;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InventoryItem::query()
                    ->with('category')
                    ->lowStock()
                    ->orderBy('current_stock')
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category'),
                TextColumn::make('current_stock')
                    ->label('Current Stock')
                    ->color(fn ($record): string => $record->isLowStock() ? 'danger' : 'success')
                    ->badge(),
                TextColumn::make('minimum_stock')
                    ->label('Min Stock')
                    ->badge(),
                TextColumn::make('unit')
                    ->badge()
                    ->color('gray'),
            ])
            ->paginated(false);
    }
}
