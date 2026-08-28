<?php

namespace App\Filament\Resources\StockIns\Pages;

use App\Filament\Resources\StockIns\StockInResource;
use App\Models\StockIn;
use App\Services\InventoryService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStockIn extends CreateRecord
{
    protected static string $resource = StockInResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = parent::handleRecordCreation($data);

        app(InventoryService::class)->stockIn(
            $record->inventoryItem,
            (float) $record->quantity,
            $record->reference_number,
            'Stock received',
            $record->notes,
            (float) $record->unit_cost,
            $record->date
        );

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return StockInResource::getUrl('index');
    }
}
