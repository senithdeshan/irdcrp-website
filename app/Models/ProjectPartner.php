<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPartner extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'website_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function logoUrl(): string
    {
        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        return asset('storage/'.ltrim($this->logo, '/'));
    }

    public function hasWebsite(): bool
    {
        return filled($this->website_url);
    }
}
