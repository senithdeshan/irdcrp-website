<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CercDocument extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_original_name',
        'file_date',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'file_date' => 'date',
        ];
    }

    public function fileExists(): bool
    {
        return filled($this->file_path) && Storage::disk('public')->exists($this->file_path);
    }

    public function fileExtension(): string
    {
        return Str::upper(pathinfo($this->file_original_name ?: $this->file_path ?: '', PATHINFO_EXTENSION));
    }

    public function fileTypeLabel(): string
    {
        return match (Str::lower($this->fileExtension())) {
            'pdf' => 'PDF document',
            'doc', 'docx' => 'Word document',
            'xls', 'xlsx', 'csv' => 'Excel file',
            'ppt', 'pptx' => 'Presentation',
            'zip' => 'Archive',
            default => filled($this->file_path) ? 'Document' : 'No document',
        };
    }
}
