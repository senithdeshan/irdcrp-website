<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OtherAnnouncement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'document_path',
        'document_original_name',
        'document_mime',
        'published_date',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'published_date' => 'date',
        ];
    }

    public function documentExists(): bool
    {
        return filled($this->document_path) && Storage::disk('public')->exists($this->document_path);
    }

    public function documentExtension(): string
    {
        return Str::upper(pathinfo($this->document_original_name ?: $this->document_path ?: '', PATHINFO_EXTENSION));
    }

    public function documentTypeLabel(): string
    {
        return match (Str::lower($this->documentExtension())) {
            'pdf' => 'PDF',
            'doc', 'docx' => 'Word',
            'xls', 'xlsx', 'csv' => 'Excel',
            'ppt', 'pptx' => 'Presentation',
            default => filled($this->document_path) ? 'File' : 'No file',
        };
    }
}
