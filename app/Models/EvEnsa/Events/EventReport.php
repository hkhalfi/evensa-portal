<?php

namespace App\Models\EvEnsa\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventReport extends Model
{
    protected $table = 'event_reports';

    protected $fillable = [
        'event_id',
        'report_file',
        'global_feedback',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
