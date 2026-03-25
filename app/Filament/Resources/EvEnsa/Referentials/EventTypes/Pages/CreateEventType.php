<?php

namespace App\Filament\Resources\EvEnsa\Referentials\EventTypes\Pages;

use App\Filament\Resources\EvEnsa\Referentials\EventTypes\EventTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventType extends CreateRecord
{
    protected static string $resource = EventTypeResource::class;
}
