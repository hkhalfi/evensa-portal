<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionMember extends Model
{
    protected $fillable = [
        'name',
        'role',
        'category',
        'position',
        'email',
        'phone',
        'order',
        'is_active',
    ];
}
