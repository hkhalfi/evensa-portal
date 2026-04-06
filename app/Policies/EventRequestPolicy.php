<?php

namespace App\Policies;

use App\Models\EvEnsa\Requests\EventRequest;
use App\Models\User;

class EventRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view event requests');
    }

    public function view(User $user, EventRequest $eventRequest): bool
    {
        if ($user->hasRole('super_admin') || $user->hasRole('commission_member') || $user->hasRole('viewer')) {
            return $user->can('view event requests');
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('view event requests')
                && $this->belongsToUserInstance($user, $eventRequest);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->can('create event requests');
    }

    public function update(User $user, EventRequest $eventRequest): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('commission_member')) {
            return in_array($eventRequest->status, ['submitted', 'under_review', 'needs_revision'], true);
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('update own event requests')
                && $this->belongsToUserInstance($user, $eventRequest)
                && in_array($eventRequest->status, ['draft', 'needs_revision'], true);
        }

        return false;
    }

    public function delete(User $user, EventRequest $eventRequest): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('update own event requests')
                && $this->belongsToUserInstance($user, $eventRequest)
                && $eventRequest->status === 'draft';
        }

        return false;
    }

    public function submit(User $user, EventRequest $eventRequest): bool
    {
        if ($user->hasRole('super_admin')) {
            return $eventRequest->status === 'draft';
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('submit event requests')
                && $this->belongsToUserInstance($user, $eventRequest)
                && $eventRequest->status === 'draft';
        }

        return false;
    }

    public function review(User $user, EventRequest $eventRequest): bool
    {
        return $user->can('review event requests')
            && in_array($eventRequest->status, ['submitted'], true);
    }

    public function requestRevision(User $user, EventRequest $eventRequest): bool
    {
        return $user->can('request revision event requests')
            && in_array($eventRequest->status, ['submitted', 'under_review'], true);
    }

    public function approve(User $user, EventRequest $eventRequest): bool
    {
        return $user->can('approve event requests')
            && in_array($eventRequest->status, ['submitted', 'under_review'], true);
    }

    public function reject(User $user, EventRequest $eventRequest): bool
    {
        return $user->can('reject event requests')
            && in_array($eventRequest->status, ['submitted', 'under_review'], true);
    }

    public function createEvent(User $user, EventRequest $eventRequest): bool
    {
        if ($user->hasRole('super_admin')) {
            return $user->can('create events')
                && $eventRequest->status === 'approved'
                && $eventRequest->event === null;
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('create events')
                && $this->belongsToUserInstance($user, $eventRequest)
                && $eventRequest->status === 'approved'
                && $eventRequest->event === null;
        }

        return false;
    }

    protected function belongsToUserInstance(User $user, EventRequest $eventRequest): bool
    {
        return filled($user->instance_id)
            && filled($eventRequest->instance_id)
            && (int) $user->instance_id === (int) $eventRequest->instance_id;
    }
}
