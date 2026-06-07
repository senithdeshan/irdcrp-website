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
        'link_url',
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

    public function linkHref(): ?string
    {
        $url = trim((string) ($this->link_url ?? ''));

        return filled($url) ? $url : null;
    }

    public function hasLink(): bool
    {
        return $this->linkHref() !== null;
    }

    public function linkOpensInNewTab(): bool
    {
        $url = $this->linkHref() ?? '';

        return str_starts_with($url, 'http://') || str_starts_with($url, 'https://');
    }
}
