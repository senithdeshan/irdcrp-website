<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProcurementNotice extends Model
{
    protected $fillable = [
        'reference_no',
        'title',
        'description',
        'notice_type',
        'published_date',
        'closing_date',
        'status',
        'documents',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'published_date' => 'date',
            'closing_date' => 'date',
            'documents' => 'array',
        ];
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed'
            || ($this->closing_date && $this->closing_date->copy()->endOfDay()->isPast());
    }

    public function documentAt(int $index): ?array
    {
        $documents = $this->documents ?? [];

        return $documents[$index] ?? null;
    }

    public function hasDocumentAt(int $index): bool
    {
        $document = $this->documentAt($index);

        return is_array($document)
            && filled($document['path'] ?? null)
            && Storage::disk('public')->exists($document['path']);
    }
}
