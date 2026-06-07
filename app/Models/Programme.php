<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Programme extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'image',
        'content_blocks',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'content_blocks' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Programme $programme) {
            if (blank($programme->slug)) {
                $programme->slug = Str::slug($programme->title);
            }
        });
    }

    public function coverImageUrl(): string
    {
        return $this->storageImageUrl($this->image) ?: asset('images/hero/hero-home-02.png');
    }

    public function storageImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function normalizedContentBlocks(): array
    {
        return collect($this->content_blocks ?? [])
            ->filter(fn ($block) => is_array($block) && filled($block['type'] ?? null))
            ->values()
            ->all();
    }
}
