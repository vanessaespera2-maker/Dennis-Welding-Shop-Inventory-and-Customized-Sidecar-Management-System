<?php

namespace App\Filament\Resources\StockOuts\Pages;

use App\Filament\Resources\StockOuts\StockOutResource;
use App\Services\InventoryService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStockOut extends CreateRecord
{
    protected static string $resource = StockOutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = parent::handleRecordCreation($data);

        try {
            app(InventoryService::class)->stockOut(
                $record->inventoryItem,
                (float) $record->quantity,
                $record->reason ?? 'Stock issued',
                $record->customization_request_id,
                $record->notes,
                $record->date
            );
        } catch (\InvalidArgumentException $e) {
            $record->delete();

            Notification::make()
                ->title('Insufficient Stock')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->halt();
        }

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return StockOutResource::getUrl('index');
    }
}
