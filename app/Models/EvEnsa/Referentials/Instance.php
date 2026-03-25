<?php

namespace App\Models\EvEnsa\Referentials;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    protected $table = 'instances';

    protected $fillable = [
        'name',
        'code',
        'instance_type',
        'contact_email',
        'contact_phone',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
