<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function programmes(): HasMany
    {
        return $this->hasMany(Programme::class);
    }
}
