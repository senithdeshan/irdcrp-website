<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrmComplaint extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'admin_reply',
        'resolution_reason',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * @return array{total: int, solved: int, in_progress: int, unsolved: int}
     */
    public static function summaryStats(): array
    {
        $counts = self::query()
            ->selectRaw("status, COUNT(*) as aggregate")
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return [
            'total' => (int) $counts->sum(),
            'solved' => (int) ($counts['solved'] ?? 0),
            'in_progress' => (int) ($counts['in_progress'] ?? 0),
            'unsolved' => (int) ($counts['new'] ?? 0),
        ];
    }
}

