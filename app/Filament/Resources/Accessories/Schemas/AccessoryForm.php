<?php

namespace App\Filament\Resources\Accessories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AccessoryForm
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
                TextInput::make('price')
                    ->label('Price (₱)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('₱'),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->directory('accessories')
                    ->columnSpanFull(),
                Select::make('inventory_item_id')
                    ->label('Inventory Item')
                    ->relationship('inventoryItem', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('The item deducted from inventory when this accessory is used in production.'),
                TextInput::make('quantity_required')
                    ->label('Quantity Required per Unit')
                    ->numeric()
                    ->minValue(0),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
