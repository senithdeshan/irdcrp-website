<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVideo extends Model
{
    protected $fillable = [
        'title',
        'bullet_one',
        'bullet_two',
        'bullet_three',
        'section_key',
        'youtube_url',
        'youtube_id',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}

