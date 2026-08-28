<?php

namespace App\Filament\Resources\StockOuts;

use App\Filament\Resources\StockOuts\Pages\CreateStockOut;
use App\Filament\Resources\StockOuts\Pages\ListStockOuts;
use App\Filament\Resources\StockOuts\Pages\ViewStockOut;
use App\Filament\Resources\StockOuts\Schemas\StockOutForm;
use App\Filament\Resources\StockOuts\Tables\StockOutsTable;
use App\Models\StockOut;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class StockOutResource extends Resource
{
    protected static ?string $model = StockOut::class;

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?string $navigationLabel = 'Stock Out';

    protected static ?string $modelLabel = 'Stock Out';

    protected static ?string $pluralModelLabel = 'Stock Out';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('stock_out.manage') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return StockOutForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockOutsTable::configure($table);
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
            'index' => ListStockOuts::route('/'),
            'create' => CreateStockOut::route('/create'),
            'view' => ViewStockOut::route('/{record}'),
        ];
    }
}
