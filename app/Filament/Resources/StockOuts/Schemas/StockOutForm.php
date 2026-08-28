<?php

namespace App\Filament\Resources\StockOuts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockOutForm
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
                            ? 'Available stock: ' . number_format((float) $item->current_stock, 0) . ' ' . $item->unit
                            : null;
                    }),
                TextInput::make('quantity')
                    ->label('Quantity to Issue')
                    ->numeric()
                    ->required()
                    ->minValue(0.01)
                    ->live()
                    ->helperText(function (callable $get): ?string {
                        $item = \App\Models\InventoryItem::find($get('inventory_item_id'));
                        $quantity = (float) $get('quantity');
                        if (! $item) {
                            return null;
                        }
                        if ($quantity > (float) $item->current_stock) {
                            return 'Insufficient stock! Available: ' . number_format((float) $item->current_stock, 0) . ' ' . $item->unit;
                        }
                        $remaining = (float) $item->current_stock - $quantity;
                        return 'Remaining after: ' . number_format($remaining, 0) . ' ' . $item->unit;
                    }),
                TextInput::make('reason')
                    ->maxLength(255),
                Select::make('customization_request_id')
                    ->label('Related Customization Request')
                    ->relationship('customizationRequest', 'request_number')
                    ->nullable()
                    ->searchable()
                    ->preload(),
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(2),
            ]);
    }
}
