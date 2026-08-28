<?php

namespace App\Filament\Resources\Sidecars;

use App\Filament\Resources\Sidecars\Pages\CreateSidecar;
use App\Filament\Resources\Sidecars\Pages\EditSidecar;
use App\Filament\Resources\Sidecars\Pages\ListSidecars;
use App\Filament\Resources\Sidecars\Schemas\SidecarForm;
use App\Filament\Resources\Sidecars\Tables\SidecarsTable;
use App\Models\Sidecar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SidecarResource extends Resource
{
    protected static ?string $model = Sidecar::class;

    protected static string|UnitEnum|null $navigationGroup = 'Sidecars';

    protected static ?string $navigationLabel = 'Sidecars';

    protected static ?string $modelLabel = 'Sidecar';

    protected static ?string $pluralModelLabel = 'Sidecars';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('sidecars.manage') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return SidecarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SidecarsTable::configure($table);
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
            'index' => ListSidecars::route('/'),
            'create' => CreateSidecar::route('/create'),
            'edit' => EditSidecar::route('/{record}/edit'),
        ];
    }
}
