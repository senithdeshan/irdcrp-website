<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Report extends Model
{
    protected $fillable = [
        'title',
        'description',
        'document_path',
        'document_original_name',
        'document_mime',
        'document_date',
        'images',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'document_date' => 'date',
            'images' => 'array',
        ];
    }

    public function imageUrls(): array
    {
        return collect($this->images ?? [])
            ->filter()
            ->map(fn (string $path): string => asset('storage/'.$path))
            ->values()
            ->all();
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
            'pdf' => 'PDF report',
            'doc', 'docx' => 'Word document',
            'xls', 'xlsx', 'csv' => 'Excel file',
            'ppt', 'pptx' => 'Presentation',
            'zip' => 'Archive',
            default => filled($this->document_path) ? 'Document' : 'No document',
        };
    }
}
