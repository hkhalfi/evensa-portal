<?php

namespace App\Models\EvEnsa\Referentials;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';

    protected $fillable = [
        'name',
        'code',
        'location',
        'capacity',
        'is_internal',
        'description',
        'is_active',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'is_internal' => 'boolean',
        'is_active' => 'boolean',
    ];
}
