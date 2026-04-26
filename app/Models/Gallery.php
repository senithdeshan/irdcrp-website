<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'image',
        'item_date',
    ];

    protected function casts(): array
    {
        return [
            'item_date' => 'date',
        ];
    }
}
