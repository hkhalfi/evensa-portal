<?php

namespace App\Models\EvEnsa\Requests;

use App\Models\EvEnsa\Referentials\Category;
use App\Models\EvEnsa\Referentials\EventType;
use App\Models\EvEnsa\Referentials\Instance;
use App\Models\EvEnsa\Referentials\Venue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventRequest extends Model
{
    protected $table = 'event_requests';

    protected $fillable = [
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
        'organization_request_file',
        'status',
        'submitted_at',
        'review_notes',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'submitted_at' => 'datetime',
        'expected_attendees' => 'integer',
    ];

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

    public function documents(): HasMany
    {
        return $this->hasMany(EventRequestDocument::class);
    }
}
