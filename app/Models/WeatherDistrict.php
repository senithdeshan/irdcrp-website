<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherDistrict extends Model
{
    protected $fillable = [
        'slug',
        'name_en',
        'name_si',
        'name_ta',
        'latitude',
        'longitude',
        'image',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function imageUrl(): ?string
    {
        if (! filled($this->image)) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('storage/'.ltrim($this->image, '/'));
    }

    /**
     * @return array{id: string, lat: float, lon: float, name: array{en: string, si: string, ta: string}, image?: string}
     */
    public function toWidgetArea(): array
    {
        $area = [
            'id' => $this->slug,
            'lat' => $this->latitude,
            'lon' => $this->longitude,
            'name' => [
                'en' => $this->name_en,
                'si' => filled($this->name_si) ? $this->name_si : $this->name_en,
                'ta' => filled($this->name_ta) ? $this->name_ta : $this->name_en,
            ],
        ];

        if ($image = $this->imageUrl()) {
            $area['image'] = $image;
        }

        return $area;
    }
}
