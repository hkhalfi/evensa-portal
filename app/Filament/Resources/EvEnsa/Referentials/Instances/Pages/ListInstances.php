<?php

namespace App\Filament\Resources\EvEnsa\Referentials\Instances\Pages;

use App\Filament\Resources\EvEnsa\Referentials\Instances\InstanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInstances extends ListRecords
{
    protected static string $resource = InstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
