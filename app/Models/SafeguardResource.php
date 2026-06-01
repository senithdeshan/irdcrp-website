<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SafeguardResource extends Model
{
    public const CATEGORIES = [
        'social-management-plan-social-screening-report' => 'Social Management Plan & Social Screening Report',
        'environment-management-plan-environment-screening-plan' => 'Environment Management Plan & Environment Screening Plan',
    ];

    protected $fillable = [
        'category',
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

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? Str::headline($this->category);
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
