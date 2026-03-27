<?php

namespace App\Filament\Resources\EvEnsa\Events\Events\Pages;

use App\Filament\Resources\EvEnsa\Events\Events\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}
