<?php

namespace App\Filament\Resources\Sidecars\Pages;

use App\Filament\Resources\Sidecars\SidecarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSidecars extends ListRecords
{
    protected static string $resource = SidecarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
