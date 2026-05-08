<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'category',
        'media_type',
        'image',
        'file_path',
        'external_url',
        'description',
        'status',
        'item_date',
    ];

    protected function casts(): array
    {
        return [
            'item_date' => 'date',
        ];
    }

    public const CATEGORIES = [
        'audio' => 'Audio',
        'photos' => 'Photos',
        'videos' => 'Videos',
        'presentation' => 'Presentation',
        'voice' => 'Voice of people',
    ];

    public const MEDIA_TYPES = [
        'image' => 'Image',
        'audio' => 'Audio',
        'video' => 'Video',
        'document' => 'Document / Presentation',
        'link' => 'External link',
    ];

    public function mediaPath(): ?string
    {
        return $this->file_path ?: $this->image;
    }

    public function mediaUrl(): ?string
    {
        if ($this->external_url) {
            return $this->external_url;
        }

        $path = $this->mediaPath();

        return $path ? asset('storage/'.$path) : null;
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }

    public function mediaTypeLabel(): string
    {
        return self::MEDIA_TYPES[$this->media_type] ?? ucfirst((string) $this->media_type);
    }
}
