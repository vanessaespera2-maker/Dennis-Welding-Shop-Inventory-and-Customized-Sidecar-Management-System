<?php

namespace App\Filament\Resources\Sidecars\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SidecarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($component, $state) {
                        if (blank($state) || filled($component->getRecord()?->slug)) {
                            return;
                        }
                        $component->getContainer()->getComponent('slug')->state(Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('sidecar_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('base_price')
                    ->label('Base Price (₱)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('₱'),
                TextInput::make('available_quantity')
                    ->label('Available Quantity')
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                        'discontinued' => 'Discontinued',
                    ])
                    ->default('available')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->directory('sidecars')
                    ->columnSpanFull(),
            ]);
    }
}
