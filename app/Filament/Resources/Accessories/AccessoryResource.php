<?php

namespace App\Filament\Resources\Accessories;

use App\Filament\Resources\Accessories\Pages\CreateAccessory;
use App\Filament\Resources\Accessories\Pages\EditAccessory;
use App\Filament\Resources\Accessories\Pages\ListAccessories;
use App\Filament\Resources\Accessories\Schemas\AccessoryForm;
use App\Filament\Resources\Accessories\Tables\AccessoriesTable;
use App\Models\Accessory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class AccessoryResource extends Resource
{
    protected static ?string $model = Accessory::class;

    protected static string|UnitEnum|null $navigationGroup = 'Customization';

    protected static ?string $navigationLabel = 'Accessories';

    protected static ?string $modelLabel = 'Accessory';

    protected static ?string $pluralModelLabel = 'Accessories';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('accessories.manage') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return AccessoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccessoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccessories::route('/'),
            'create' => CreateAccessory::route('/create'),
            'edit' => EditAccessory::route('/{record}/edit'),
        ];
    }
}
