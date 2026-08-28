<?php

namespace App\Filament\Resources\SidecarCategories;

use App\Filament\Resources\SidecarCategories\Pages\CreateSidecarCategory;
use App\Filament\Resources\SidecarCategories\Pages\EditSidecarCategory;
use App\Filament\Resources\SidecarCategories\Pages\ListSidecarCategories;
use App\Filament\Resources\SidecarCategories\Schemas\SidecarCategoryForm;
use App\Filament\Resources\SidecarCategories\Tables\SidecarCategoriesTable;
use App\Models\SidecarCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SidecarCategoryResource extends Resource
{
    protected static ?string $model = SidecarCategory::class;

    protected static string|UnitEnum|null $navigationGroup = 'Sidecars';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $modelLabel = 'Category';

    protected static ?string $pluralModelLabel = 'Categories';

    protected static ?int $navigationSort = 1;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('sidecar_categories.manage') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return SidecarCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SidecarCategoriesTable::configure($table);
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
            'index' => ListSidecarCategories::route('/'),
            'create' => CreateSidecarCategory::route('/create'),
            'edit' => EditSidecarCategory::route('/{record}/edit'),
        ];
    }
}
