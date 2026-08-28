<?php

namespace App\Filament\Resources\CustomizationRequests\Schemas;

use App\Models\Accessory;
use App\Models\Color;
use App\Models\Material;
use App\Models\Sidecar;
use App\Services\PriceCalculator;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomizationRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('request_number')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit'),
                Select::make('user_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('sidecar_id')
                    ->label('Sidecar')
                    ->relationship('sidecar', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn (callable $get, callable $set) => self::recalculatePrice($get, $set)),
                Select::make('material_id')
                    ->label('Material')
                    ->relationship('material', 'name')
                    ->options(fn () => Material::query()->where('is_active', true)->pluck('name', 'id'))
                    ->nullable()
                    ->live()
                    ->afterStateUpdated(fn (callable $get, callable $set) => self::recalculatePrice($get, $set)),
                Select::make('color_id')
                    ->label('Color')
                    ->relationship('color', 'name')
                    ->options(fn () => Color::query()->where('is_active', true)->pluck('name', 'id'))
                    ->nullable()
                    ->live()
                    ->afterStateUpdated(fn (callable $get, callable $set) => self::recalculatePrice($get, $set)),
                Select::make('accessories')
                    ->label('Accessories')
                    ->relationship('accessories', 'name')
                    ->options(fn () => Accessory::query()->where('is_active', true)->pluck('name', 'id'))
                    ->multiple()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn (callable $get, callable $set) => self::recalculatePrice($get, $set)),
                TextInput::make('estimated_price')
                    ->label('Estimated Price (₱)')
                    ->numeric()
                    ->prefix('₱')
                    ->default(0)
                    ->dehydrated()
                    ->disabled()
                    ->helperText('Automatically computed from the selected options.'),
                TextInput::make('final_price')
                    ->label('Final Price (₱)')
                    ->numeric()
                    ->minValue(0)
                    ->prefix('₱')
                    ->nullable()
                    ->visibleOn('edit'),
                Select::make('status')
                    ->options(\App\Models\CustomizationRequest::STATUSES)
                    ->default(\App\Models\CustomizationRequest::STATUS_PENDING)
                    ->required(),
                TextInput::make('preferred_dimensions')
                    ->label('Preferred Dimensions')
                    ->maxLength(255),
                DateTimePicker::make('date_submitted')
                    ->label('Date Submitted')
                    ->required()
                    ->default(now()),
                Textarea::make('special_instructions')
                    ->label('Special Instructions')
                    ->columnSpanFull()
                    ->rows(2),
                Textarea::make('design_notes')
                    ->label('Design Notes')
                    ->columnSpanFull()
                    ->rows(2),
                FileUpload::make('design_image')
                    ->image()
                    ->imageEditor()
                    ->directory('designs')
                    ->columnSpanFull(),
                DateTimePicker::make('approved_at')
                    ->visibleOn('edit'),
                DateTimePicker::make('in_production_at')
                    ->visibleOn('edit'),
                DateTimePicker::make('completed_at')
                    ->visibleOn('edit'),
                DateTimePicker::make('rejected_at')
                    ->visibleOn('edit'),
            ]);
    }

    protected static function recalculatePrice(callable $get, callable $set): void
    {
        $sidecar = Sidecar::find($get('sidecar_id'));
        if (! $sidecar) {
            $set('estimated_price', 0);
            return;
        }

        $material = Material::find($get('material_id'));
        $color = Color::find($get('color_id'));
        $accessoryIds = $get('accessories') ?? [];
        $accessories = Accessory::whereIn('id', $accessoryIds)->get();

        $accessoryMap = [];
        foreach ($accessories as $accessory) {
            $accessoryMap[$accessory->id] = $accessory;
        }

        $estimated = PriceCalculator::calculate($sidecar, $material, $color, $accessoryMap);
        $set('estimated_price', $estimated);
    }
}
