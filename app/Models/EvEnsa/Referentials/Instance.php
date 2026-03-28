<?php

namespace App\Models\EvEnsa\Referentials;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
