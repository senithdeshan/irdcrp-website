<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyLeader extends Model
{
    protected $fillable = [
        'sort_order',
        'is_active',
        'image',
        'role_en',
        'role_si',
        'role_ta',
        'org_en',
        'org_si',
        'org_ta',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Localized role or organisation (falls back to English).
     */
    public function label(string $field, ?string $locale = null): string
    {
        $loc = in_array($locale, ['en', 'si', 'ta'], true) ? $locale : 'en';
        $key = "{$field}_{$loc}";
        $fallback = $this->{"{$field}_en"} ?? '';

        return filled($this->$key) ? (string) $this->$key : $fallback;
    }
}
