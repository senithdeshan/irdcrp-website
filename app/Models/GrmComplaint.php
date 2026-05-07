<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrmComplaint extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'admin_reply',
        'resolution_reason',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }
}

