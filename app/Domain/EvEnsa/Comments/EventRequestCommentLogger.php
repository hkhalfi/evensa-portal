<?php

namespace App\Domain\EvEnsa\Comments;

use App\Models\EvEnsa\Requests\EventRequest;
use App\Models\EvEnsa\Requests\EventRequestComment;
use App\Models\User;

class EventRequestCommentLogger
{
    public function log(
        EventRequest $eventRequest,
        User $actor,
        string $comment,
        ?string $commentType = null,
    ): EventRequestComment {
        return EventRequestComment::create([
            'event_request_id' => $eventRequest->id,
            'user_id' => $actor->id,
            'comment' => $comment,
            'comment_type' => $commentType,
        ]);
    }
}
