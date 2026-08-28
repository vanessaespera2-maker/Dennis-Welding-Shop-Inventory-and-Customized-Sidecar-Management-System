<?php

namespace App\Filament\Resources\Sidecars\Pages;

use App\Filament\Resources\Sidecars\SidecarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSidecar extends EditRecord
{
    protected static string $resource = SidecarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
