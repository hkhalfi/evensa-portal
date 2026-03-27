<?php

namespace App\Filament\Resources\EvEnsa\Events\Events\Pages;

use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
