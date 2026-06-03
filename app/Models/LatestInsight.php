<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LatestInsight extends Model
{
    protected $fillable = [
        'title',
        'category',
        'summary',
        'image',
        'insight_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'insight_date' => 'date',
        ];
    }

    public function imageUrl(): string
    {
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/'.preg_replace('#^/?storage/#', '', ltrim($this->image, '/')));
    }
}
