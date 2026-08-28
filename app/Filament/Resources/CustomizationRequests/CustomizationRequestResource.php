<?php

namespace App\Filament\Resources\CustomizationRequests;

use App\Filament\Resources\CustomizationRequests\Pages\CreateCustomizationRequest;
use App\Filament\Resources\CustomizationRequests\Pages\EditCustomizationRequest;
use App\Filament\Resources\CustomizationRequests\Pages\ListCustomizationRequests;
use App\Filament\Resources\CustomizationRequests\Pages\ViewCustomizationRequest;
use App\Filament\Resources\CustomizationRequests\Schemas\CustomizationRequestForm;
use App\Filament\Resources\CustomizationRequests\Tables\CustomizationRequestsTable;
use App\Models\CustomizationRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CustomizationRequestResource extends Resource
{
    protected static ?string $model = CustomizationRequest::class;

    protected static string|UnitEnum|null $navigationGroup = 'Customization';

    protected static ?string $navigationLabel = 'Customization Requests';

    protected static ?string $modelLabel = 'Customization Request';

    protected static ?string $pluralModelLabel = 'Customization Requests';

    protected static ?int $navigationSort = 4;

    protected static bool $shouldSkipAuthorization = true;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('customization_requests.manage') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return CustomizationRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomizationRequestsTable::configure($table);
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
            'index' => ListCustomizationRequests::route('/'),
            'create' => CreateCustomizationRequest::route('/create'),
            'view' => ViewCustomizationRequest::route('/{record}'),
            'edit' => EditCustomizationRequest::route('/{record}/edit'),
        ];
    }
}
