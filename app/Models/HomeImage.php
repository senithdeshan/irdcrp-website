<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class HomeImage extends Model
{
    protected $fillable = [
        'slot',
        'title',
        'caption',
        'image_path',
        'fallback_path',
        'sort_order',
        'is_active',
        'display_from',
        'display_until',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'display_from' => 'date',
            'display_until' => 'date',
        ];
    }

    public function imageUrl(): string
    {
        $path = $this->image_path ?: $this->fallback_path;

        if (str_starts_with((string) $path, 'http')) {
            return $path;
        }

        if ($path && ! str_starts_with($path, 'images/') && ! str_starts_with($path, '/images/')) {
            return '/storage/'.ltrim((string) $path, '/');
        }

        return '/'.ltrim((string) $path, '/');
    }

    public function scopeVisibleOnHome(Builder $query): Builder
    {
        $today = now()->toDateString();

        return $query
            ->where('is_active', true)
            ->where(function (Builder $query) use ($today): void {
                $query->whereNull('display_from')
                    ->orWhereDate('display_from', '<=', $today);
            })
            ->where(function (Builder $query) use ($today): void {
                $query->whereNull('display_until')
                    ->orWhereDate('display_until', '>=', $today);
            });
    }

    public function isWithinDisplayPeriod(?Carbon $date = null): bool
    {
        $date = ($date ?? now())->startOfDay();

        if ($this->display_from && $date->lt($this->display_from->startOfDay())) {
            return false;
        }

        if ($this->display_until && $date->gt($this->display_until->startOfDay())) {
            return false;
        }

        return true;
    }

    /**
     * @return 'hidden'|'scheduled'|'expired'|'live'|'always'
     */
    public function scheduleStatus(): string
    {
        if (! $this->is_active) {
            return 'hidden';
        }

        if (! $this->display_from && ! $this->display_until) {
            return 'always';
        }

        $today = now()->startOfDay();

        if ($this->display_from && $today->lt($this->display_from->startOfDay())) {
            return 'scheduled';
        }

        if ($this->display_until && $today->gt($this->display_until->startOfDay())) {
            return 'expired';
        }

        return 'live';
    }

    public function scheduleLabel(): string
    {
        if (! $this->display_from && ! $this->display_until) {
            return 'Always visible';
        }

        $from = $this->display_from?->format('M j, Y');
        $until = $this->display_until?->format('M j, Y');

        if ($from && $until) {
            return $from.' – '.$until;
        }

        if ($from) {
            return 'From '.$from;
        }

        return 'Until '.$until;
    }
}
