<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class HomeImage extends Model
{
    protected $fillable = [
        'slot',
        'title',
        'caption',
        'image_path',
        'fallback_path',
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

    public function imageUrl(): string
    {
        $path = $this->image_path ?: $this->fallback_path;

        if (str_starts_with((string) $path, 'http')) {
            return $path;
        }

        if ($path && ! str_starts_with($path, 'images/') && ! str_starts_with($path, '/images/')) {
            return '/storage/'.ltrim((string) $path, '/');
        }

        return '/'.ltrim((string) $path, '/');
    }
}
