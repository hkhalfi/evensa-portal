<?php

namespace App\Domain\EvEnsa\Workflows;

use App\Domain\EvEnsa\Exceptions\BusinessRuleViolationException;
use App\Domain\EvEnsa\Exceptions\InvalidWorkflowTransitionException;
use App\Models\EvEnsa\Events\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EventWorkflow
{
    public function schedule(Event $event, User $actor): void
    {
        if ($event->status !== 'draft') {
            throw new InvalidWorkflowTransitionException(
                'Seul un événement en brouillon peut être planifié.'
            );
        }

        if (
            blank($event->start_at) ||
            blank($event->end_at) ||
            $event->start_at >= $event->end_at
        ) {
            throw new BusinessRuleViolationException(
                'Les dates de début et de fin doivent être valides.'
            );
        }

        DB::transaction(function () use ($event): void {
            $event->update([
                'status' => 'scheduled',
            ]);
        });
    }

    public function publish(Event $event, User $actor): void
    {
        if (! in_array($event->status, ['draft', 'scheduled'], true)) {
            throw new InvalidWorkflowTransitionException(
                'Cet événement ne peut pas être publié dans son état actuel.'
            );
        }

        if (blank($event->title)) {
            throw new BusinessRuleViolationException(
                'Le titre est obligatoire.'
            );
        }

        if (
            blank($event->instance_id) ||
            blank($event->event_type_id) ||
            blank($event->category_id)
        ) {
            throw new BusinessRuleViolationException(
                'Instance, type et catégorie sont obligatoires.'
            );
        }

        if (
            blank($event->start_at) ||
            blank($event->end_at) ||
            $event->start_at >= $event->end_at
        ) {
            throw new BusinessRuleViolationException(
                'Les dates de début et de fin sont invalides.'
            );
        }

        if (blank($event->description)) {
            throw new BusinessRuleViolationException(
                'La description est obligatoire avant publication.'
            );
        }

        DB::transaction(function () use ($event): void {
            $event->update([
                'status' => 'published',
                'is_published' => true,
                'published_at' => now(),
            ]);
        });
    }

    public function unpublish(Event $event, User $actor): void
    {
        if (! $event->is_published || $event->status !== 'published') {
            throw new InvalidWorkflowTransitionException(
                'Seul un événement publié peut être dépublié.'
            );
        }

        DB::transaction(function () use ($event): void {
            $event->update([
                'status' => 'scheduled',
                'is_published' => false,
                'published_at' => null,
            ]);
        });
    }

    public function complete(Event $event, User $actor): void
    {
        if (! in_array($event->status, ['scheduled', 'published'], true)) {
            throw new InvalidWorkflowTransitionException(
                'Seul un événement planifié ou publié peut être marqué comme terminé.'
            );
        }

        DB::transaction(function () use ($event): void {
            $event->update([
                'status' => 'completed',
                'is_published' => false,
            ]);
        });
    }

    public function archive(Event $event, User $actor): void
    {
        if (! in_array($event->status, ['scheduled', 'published', 'completed'], true)) {
            throw new InvalidWorkflowTransitionException(
                'Cet événement ne peut pas être archivé dans son état actuel.'
            );
        }

        DB::transaction(function () use ($event): void {
            $event->update([
                'status' => 'archived',
                'is_published' => false,
                'published_at' => null,
            ]);
        });
    }
}
