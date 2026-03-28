<?php

namespace App\Models\EvEnsa\Events;

use App\Models\EvEnsa\Referentials\Category;
use App\Models\EvEnsa\Referentials\EventType;
use App\Models\EvEnsa\Referentials\Instance;
use App\Models\EvEnsa\Referentials\Venue;
use App\Models\EvEnsa\Requests\EventRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'event_request_id',
        'title',
        'instance_id',
        'event_type_id',
        'category_id',
        'venue_id',
        'event_mode',
        'start_at',
        'end_at',
        'expected_attendees',
        'description',
        'status',
        'is_published',
        'published_at',
        'cover_image',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'expected_attendees' => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function eventRequest(): BelongsTo
    {
        return $this->belongsTo(EventRequest::class);
    }

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(EventReport::class);
    }
}
