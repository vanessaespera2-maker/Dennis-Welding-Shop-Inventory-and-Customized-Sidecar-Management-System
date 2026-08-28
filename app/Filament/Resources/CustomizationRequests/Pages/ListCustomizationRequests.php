<?php

namespace App\Filament\Resources\CustomizationRequests\Pages;

use App\Filament\Resources\CustomizationRequests\CustomizationRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCustomizationRequests extends ListRecords
{
    protected static string $resource = CustomizationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
