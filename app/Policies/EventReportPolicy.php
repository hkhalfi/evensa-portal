<?php

namespace App\Policies;

use App\Models\EvEnsa\Events\EventReport;
use App\Models\User;

class EventReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view event reports');
    }

    public function view(User $user, EventReport $eventReport): bool
    {
        return $user->can('view event reports');
    }

    public function create(User $user): bool
    {
        return $user->can('create event reports');
    }

    public function update(User $user, EventReport $eventReport): bool
    {
        return $user->can('create event reports');
    }

    public function delete(User $user, EventReport $eventReport): bool
    {
        return $user->hasRole('super_admin');
    }
}
