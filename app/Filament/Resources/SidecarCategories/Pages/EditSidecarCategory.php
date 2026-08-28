<?php

namespace App\Filament\Resources\SidecarCategories\Pages;

use App\Filament\Resources\SidecarCategories\SidecarCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSidecarCategory extends EditRecord
{
    protected static string $resource = SidecarCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
