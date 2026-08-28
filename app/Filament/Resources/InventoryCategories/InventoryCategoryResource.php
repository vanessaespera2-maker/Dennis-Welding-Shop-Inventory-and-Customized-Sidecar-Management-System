<?php

namespace App\Filament\Resources\InventoryCategories;

use App\Filament\Resources\InventoryCategories\Pages\CreateInventoryCategory;
use App\Filament\Resources\InventoryCategories\Pages\EditInventoryCategory;
use App\Filament\Resources\InventoryCategories\Pages\ListInventoryCategories;
use App\Filament\Resources\InventoryCategories\Schemas\InventoryCategoryForm;
use App\Filament\Resources\InventoryCategories\Tables\InventoryCategoriesTable;
use App\Models\InventoryCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class InventoryCategoryResource extends Resource
{
    protected static ?string $model = InventoryCategory::class;

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?string $navigationLabel = 'Inventory Categories';

    protected static ?string $modelLabel = 'Inventory Category';

    protected static ?string $pluralModelLabel = 'Inventory Categories';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('inventory.categories.manage') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return InventoryCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryCategoriesTable::configure($table);
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
            'index' => ListInventoryCategories::route('/'),
            'create' => CreateInventoryCategory::route('/create'),
            'edit' => EditInventoryCategory::route('/{record}/edit'),
        ];
    }
}
