<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(2),
                TextInput::make('additional_price')
                    ->label('Additional Price (₱)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('₱'),
                Select::make('inventory_item_id')
                    ->label('Inventory Item')
                    ->relationship('inventoryItem', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('The item deducted from inventory when this material is used in production.'),
                TextInput::make('quantity_required')
                    ->label('Quantity Required per Use')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Amount deducted from the linked inventory item.'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
