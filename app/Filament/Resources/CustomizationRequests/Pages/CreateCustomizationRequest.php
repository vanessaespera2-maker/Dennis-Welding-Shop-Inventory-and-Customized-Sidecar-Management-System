<?php

namespace App\Filament\Resources\CustomizationRequests\Pages;

use App\Filament\Resources\CustomizationRequests\CustomizationRequestResource;
use App\Models\CustomizationRequest;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomizationRequest extends CreateRecord
{
    protected static string $resource = CustomizationRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['request_number'] = CustomizationRequest::generateRequestNumber();

        return $data;
    }
}
