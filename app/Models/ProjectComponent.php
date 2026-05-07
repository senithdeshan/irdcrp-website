<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectComponent extends Model
{
    protected $fillable = [
        'component_number',
        'title',
        'budget',
        'beneficiaries',
        'description',
        'sort_order',
        'status',
    ];
}
