<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_date',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'file_date' => 'date',
        ];
    }
}
