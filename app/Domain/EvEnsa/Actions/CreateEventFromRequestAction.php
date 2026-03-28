<?php

namespace App\Domain\EvEnsa\Actions;

use App\Domain\EvEnsa\Comments\EventRequestCommentLogger;
use App\Domain\EvEnsa\Exceptions\BusinessRuleViolationException;
use App\Models\EvEnsa\Events\Event;
use App\Models\EvEnsa\Requests\EventRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateEventFromRequestAction
{
    public function __construct(
        protected EventRequestCommentLogger $comments,
    ) {}

    public function execute(EventRequest $eventRequest, User $actor): Event
    {
        if ($eventRequest->status !== 'approved') {
            throw new BusinessRuleViolationException(
                'Seule une demande approuvée peut créer un événement.'
            );
        }

        if ($eventRequest->event !== null) {
            throw new BusinessRuleViolationException(
                'Un événement existe déjà pour cette demande.'
            );
        }

        return DB::transaction(function () use ($eventRequest, $actor): Event {
            $event = Event::create([
                'event_request_id' => $eventRequest->id,
                'title' => $eventRequest->title,
                'instance_id' => $eventRequest->instance_id,
                'event_type_id' => $eventRequest->event_type_id,
                'category_id' => $eventRequest->category_id,
                'venue_id' => $eventRequest->venue_id,
                'event_mode' => $eventRequest->event_mode,
                'start_at' => $eventRequest->start_at,
                'end_at' => $eventRequest->end_at,
                'expected_attendees' => $eventRequest->expected_attendees,
                'description' => $eventRequest->description,
                'status' => 'draft',
                'is_published' => false,
            ]);

            $this->comments->log(
                $eventRequest,
                $actor,
                'Événement créé à partir de la demande approuvée.',
                'decision_note',
            );

            return $event;
        });
    }
}
