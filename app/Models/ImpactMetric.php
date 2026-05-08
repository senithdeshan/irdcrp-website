<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpactMetric extends Model
{
    protected $fillable = [
        'key',
        'label',
        'value',
        'count_target',
        'helper',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'count_target' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
