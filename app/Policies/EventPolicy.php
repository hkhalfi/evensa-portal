<?php

namespace App\Policies;

use App\Models\EvEnsa\Events\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view events');
    }

    public function view(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin') || $user->hasRole('commission_member') || $user->hasRole('viewer')) {
            return $user->can('view events');
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('view events')
                && $this->belongsToUserInstance($user, $event);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->can('create events');
    }

    public function update(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('commission_member')) {
            return false;
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('update events')
                && $this->belongsToUserInstance($user, $event)
                && ! in_array($event->status, ['archived'], true);
        }

        return false;
    }

    public function delete(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('update events')
                && $this->belongsToUserInstance($user, $event)
                && $event->status === 'draft';
        }

        return false;
    }

    public function schedule(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin')) {
            return $user->can('schedule events')
                && $event->status === 'draft';
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('schedule events')
                && $this->belongsToUserInstance($user, $event)
                && $event->status === 'draft';
        }

        return false;
    }

    public function publish(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin')) {
            return $user->can('publish events')
                && in_array($event->status, ['draft', 'scheduled'], true);
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('publish events')
                && $this->belongsToUserInstance($user, $event)
                && in_array($event->status, ['draft', 'scheduled'], true);
        }

        return false;
    }

    public function unpublish(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin')) {
            return $user->can('unpublish events')
                && $event->status === 'published'
                && $event->is_published;
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('unpublish events')
                && $this->belongsToUserInstance($user, $event)
                && $event->status === 'published'
                && $event->is_published;
        }

        return false;
    }

    public function complete(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin')) {
            return $user->can('complete events')
                && in_array($event->status, ['scheduled', 'published'], true);
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('complete events')
                && $this->belongsToUserInstance($user, $event)
                && in_array($event->status, ['scheduled', 'published'], true);
        }

        return false;
    }

    public function archive(User $user, Event $event): bool
    {
        if ($user->hasRole('super_admin')) {
            return $user->can('archive events')
                && in_array($event->status, ['scheduled', 'published', 'completed'], true);
        }

        if ($user->hasRole('instance_manager')) {
            return $user->can('archive events')
                && $this->belongsToUserInstance($user, $event)
                && in_array($event->status, ['scheduled', 'published', 'completed'], true);
        }

        return false;
    }

    protected function belongsToUserInstance(User $user, Event $event): bool
    {
        return filled($user->instance_id)
            && filled($event->instance_id)
            && (int) $user->instance_id === (int) $event->instance_id;
    }
}
