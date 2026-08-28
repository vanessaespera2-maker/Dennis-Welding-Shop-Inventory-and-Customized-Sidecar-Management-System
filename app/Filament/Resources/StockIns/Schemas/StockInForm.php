<?php

namespace App\Filament\Resources\StockIns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockInForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('inventory_item_id')
                    ->label('Inventory Item')
                    ->relationship('inventoryItem', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->helperText(function (callable $get): ?string {
                        $item = \App\Models\InventoryItem::find($get('inventory_item_id'));
                        return $item
                            ? 'Current stock: ' . number_format((float) $item->current_stock, 0) . ' ' . $item->unit
                            : null;
                    })
                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                        if ($operation === 'edit' || ! $state) {
                            return;
                        }
                        $item = \App\Models\InventoryItem::find($state);
                        if ($item) {
                            $set('unit_cost', $item->unit_cost);
                        }
                    }),
                TextInput::make('quantity')
                    ->label('Quantity to Add')
                    ->numeric()
                    ->required()
                    ->minValue(0.01),
                TextInput::make('unit_cost')
                    ->numeric()
                    ->prefix('₱')
                    ->required()
                    ->default(0)
                    ->minValue(0),
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'name')
                    ->nullable()
                    ->preload()
                    ->searchable(),
                TextInput::make('reference_number')
                    ->label('Reference Number')
                    ->maxLength(100),
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(2),
            ]);
    }
}
