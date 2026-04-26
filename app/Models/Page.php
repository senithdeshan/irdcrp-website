<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];

    public static function booted(): void
    {
        static::saving(function (Page $page) {
            if (empty($page->slug) && ! empty($page->title)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
