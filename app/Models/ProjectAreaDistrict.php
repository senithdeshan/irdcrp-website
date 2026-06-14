<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProjectAreaDistrict extends Model
{
    protected $fillable = [
        'district',
        'ds_divisions',
        'focus',
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

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOrderedForDisplay(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('district');
    }

    /**
     * @return array{district: string, ds_divisions: string, focus: string}
     */
    public function toTableRow(): array
    {
        return [
            'district' => $this->district,
            'ds_divisions' => (string) ($this->ds_divisions ?? ''),
            'focus' => (string) ($this->focus ?? ''),
        ];
    }
}
