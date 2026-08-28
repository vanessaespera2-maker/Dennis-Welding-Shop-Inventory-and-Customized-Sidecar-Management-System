<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('guard_name')
                            ->label('Guard')
                            ->options(['web' => 'web', 'api' => 'api'])
                            ->default('web')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                    ]),
                CheckboxList::make('permissions')
                    ->label('Permissions')
                    ->relationship('permissions', 'name')
                    ->options(Permission::query()->orderBy('name')->pluck('name', 'id'))
                    ->columns(2)
                    ->gridDirection('row'),
            ]);
    }
}
