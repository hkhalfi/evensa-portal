<?php

namespace App\Models\EvEnsa\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRequestDocument extends Model
{
    protected $table = 'event_request_documents';

    protected $fillable = [
        'event_request_id',
        'document_type',
        'title',
        'file_path',
        'notes',
    ];

    public function eventRequest(): BelongsTo
    {
        return $this->belongsTo(EventRequest::class);
    }
}
