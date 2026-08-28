<?php

namespace App\Filament\Resources\SidecarCategories\Pages;

use App\Filament\Resources\SidecarCategories\SidecarCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSidecarCategories extends ListRecords
{
    protected static string $resource = SidecarCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
