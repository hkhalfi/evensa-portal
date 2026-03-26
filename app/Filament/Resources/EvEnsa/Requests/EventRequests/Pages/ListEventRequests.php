<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages;

use App\Filament\Resources\EvEnsa\Requests\EventRequests\EventRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventRequests extends ListRecords
{
    protected static string $resource = EventRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
