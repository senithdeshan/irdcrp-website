<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Programme extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'image',
        'sort_order',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function (Programme $programme) {
            if (blank($programme->slug)) {
                $programme->slug = Str::slug($programme->title);
            }
        });
    }
}
