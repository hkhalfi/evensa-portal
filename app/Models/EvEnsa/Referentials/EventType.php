<?php

namespace App\Models\EvEnsa\Referentials;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table = 'event_types';

    protected $fillable = [
        'name',
        'code',
        'description',
        'minimum_submission_days',
        'is_active',
    ];

    protected $casts = [
        'minimum_submission_days' => 'integer',
        'is_active' => 'boolean',
    ];
}
