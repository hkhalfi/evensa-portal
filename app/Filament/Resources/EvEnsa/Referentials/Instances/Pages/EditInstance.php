<?php

namespace App\Filament\Resources\EvEnsa\Referentials\Instances\Pages;

use App\Filament\Resources\EvEnsa\Referentials\Instances\InstanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInstance extends EditRecord
{
    protected static string $resource = InstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
