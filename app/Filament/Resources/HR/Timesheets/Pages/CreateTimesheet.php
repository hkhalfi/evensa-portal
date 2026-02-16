<?php

namespace App\Filament\Resources\HR\Timesheets\Pages;

use App\Filament\Resources\HR\Timesheets\TimesheetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTimesheet extends CreateRecord
{
    protected static string $resource = TimesheetResource::class;
}
