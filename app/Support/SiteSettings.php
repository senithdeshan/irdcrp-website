<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SiteSettings
{
    public const SOCIAL_KEYS = [
        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        'instagram',
    ];

    public function socialLinks(): array
    {
        $defaults = config('irdcrp.social', []);

        if (! Schema::hasTable('site_settings')) {
            return $defaults;
        }

        $saved = Cache::rememberForever('irdcrp.site_settings.social', function (): array {
            return SiteSetting::query()
                ->whereIn('key', array_map(fn (string $key): string => "social.$key", self::SOCIAL_KEYS))
                ->pluck('value', 'key')
                ->mapWithKeys(fn (?string $value, string $key): array => [str_replace('social.', '', $key) => $value])
                ->all();
        });

        return array_merge($defaults, array_filter($saved, fn ($value): bool => filled($value)));
    }

    public function putSocialLinks(array $links): void
    {
        foreach (self::SOCIAL_KEYS as $key) {
            SiteSetting::query()->updateOrCreate(
                ['key' => "social.$key"],
                ['value' => $links[$key] ?? null],
            );
        }

        Cache::forget('irdcrp.site_settings.social');
    }
}
