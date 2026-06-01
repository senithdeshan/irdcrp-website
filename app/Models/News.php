<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $casts = [
        'images' => 'array',
        'published_date' => 'date',
    ];

    protected $fillable = [
        'title_en',
        'title_si',
        'title_ta',
        'content_en',
        'content_si',
        'content_ta',
        'image',
        'images',
        'published_date',
        'status',
    ];

    public function imagePaths(): array
    {
        return collect([$this->image])
            ->merge($this->images ?? [])
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function imageUrl(?string $path = null): ?string
    {
        $path = $path ?: ($this->imagePaths()[0] ?? null);

        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/') || str_starts_with($path, '/images/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/'.preg_replace('#^/?storage/#', '', ltrim($path, '/')));
    }

    public function imageUrls(): array
    {
        return collect($this->imagePaths())
            ->map(fn (string $path) => $this->imageUrl($path))
            ->filter()
            ->values()
            ->all();
    }
}
