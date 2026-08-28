<?php

namespace App\Filament\Resources\CustomizationRequests\Pages;

use App\Filament\Resources\CustomizationRequests\CustomizationRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomizationRequest extends EditRecord
{
    protected static string $resource = CustomizationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
