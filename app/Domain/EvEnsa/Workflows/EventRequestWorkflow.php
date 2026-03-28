<?php

namespace App\Domain\EvEnsa\Workflows;

use App\Domain\EvEnsa\Comments\EventRequestCommentLogger;
use App\Domain\EvEnsa\Exceptions\BusinessRuleViolationException;
use App\Domain\EvEnsa\Exceptions\InvalidWorkflowTransitionException;
use App\Models\EvEnsa\Requests\EventRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EventRequestWorkflow
{
    public function __construct(
        protected EventRequestCommentLogger $comments,
    ) {}

    public function submit(EventRequest $eventRequest, User $actor): void
    {
        // 1. Vérifier transition
        if ($eventRequest->status !== 'draft') {
            throw new InvalidWorkflowTransitionException(
                'Seule une demande en brouillon peut être soumise.'
            );
        }

        // 2. Vérifier règles métier
        if (blank($eventRequest->organization_request_file)) {
            throw new BusinessRuleViolationException(
                'La demande d’organisation est obligatoire.'
            );
        }

        if (
            blank($eventRequest->start_at) ||
            blank($eventRequest->end_at) ||
            $eventRequest->start_at >= $eventRequest->end_at
        ) {
            throw new BusinessRuleViolationException(
                'Les dates sont invalides.'
            );
        }

        // 3. Appliquer transition
        DB::transaction(function () use ($eventRequest, $actor) {

            $eventRequest->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            // 4. Journaliser
            $this->comments->log(
                $eventRequest,
                $actor,
                'Demande soumise.',
                'decision_note'
            );
        });
    }

    public function approve(EventRequest $eventRequest, User $actor): void
    {
        if (! in_array($eventRequest->status, ['submitted', 'under_review'])) {
            throw new InvalidWorkflowTransitionException(
                'Impossible d’approuver cette demande.'
            );
        }

        DB::transaction(function () use ($eventRequest, $actor) {

            $eventRequest->update([
                'status' => 'approved',
            ]);

            $this->comments->log(
                $eventRequest,
                $actor,
                'Demande approuvée.',
                'decision_note'
            );
        });
    }

    public function reject(EventRequest $eventRequest, User $actor, string $reason): void
    {
        if (! in_array($eventRequest->status, ['submitted', 'under_review'])) {
            throw new InvalidWorkflowTransitionException(
                'Impossible de rejeter cette demande.'
            );
        }

        if (blank($reason)) {
            throw new BusinessRuleViolationException(
                'Le motif de rejet est obligatoire.'
            );
        }

        DB::transaction(function () use ($eventRequest, $actor, $reason) {

            $eventRequest->update([
                'status' => 'rejected',
            ]);

            $this->comments->log(
                $eventRequest,
                $actor,
                $reason,
                'decision_note'
            );
        });
    }
}
