<?php

namespace App\Filament\Resources\InventoryItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InventoryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sku')
                    ->required()
                    ->unique(table: \App\Models\InventoryItem::class, ignoreRecord: true)
                    ->maxLength(100),
                Select::make('inventory_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->preload(),
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'name')
                    ->nullable()
                    ->preload()
                    ->searchable(),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(2),
                Select::make('unit')
                    ->options([
                        'pcs' => 'pcs',
                        'meters' => 'meters',
                        'kg' => 'kg',
                        'liters' => 'liters',
                        'sets' => 'sets',
                    ])
                    ->default('pcs')
                    ->required(),
                TextInput::make('current_stock')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->helperText('Stock is updated through Stock In / Stock Out.'),
                TextInput::make('minimum_stock')
                    ->label('Minimum Stock')
                    ->numeric()
                    ->required()
                    ->default(0),
                TextInput::make('unit_cost')
                    ->label('Unit Cost')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->prefix('₱'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }
}
