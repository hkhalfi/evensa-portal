<?php

namespace App\Filament\Resources\EvEnsa\Requests\EventRequests\Pages;

use App\Filament\Resources\EvEnsa\Requests\EventRequests\EventRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventRequest extends CreateRecord
{
    protected static string $resource = EventRequestResource::class;
}
