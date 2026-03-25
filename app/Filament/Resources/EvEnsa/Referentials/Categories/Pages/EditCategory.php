<?php

namespace App\Filament\Resources\EvEnsa\Referentials\Categories\Pages;

use App\Filament\Resources\EvEnsa\Referentials\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
