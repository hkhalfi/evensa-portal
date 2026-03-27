<?php

namespace App\Models\EvEnsa\Requests;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRequestComment extends Model
{
    protected $table = 'event_request_comments';

    protected $fillable = [
        'event_request_id',
        'user_id',
        'comment_type',
        'comment',
    ];

    public function eventRequest(): BelongsTo
    {
        return $this->belongsTo(EventRequest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
