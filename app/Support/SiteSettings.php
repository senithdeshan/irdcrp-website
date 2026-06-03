<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteSettings
{
    public const SOCIAL_KEYS = [
        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        'instagram',
    ];

    public const FOOTER_KEYS = [
        'project_name',
        'address',
        'email',
        'phone',
        'logo',
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

    public function footer(): array
    {
        $defaults = [
            'project_name' => config('irdcrp.project_name.en', config('app.name', 'IRDCRP')),
            'address' => config('irdcrp.contact.address'),
            'email' => config('irdcrp.contact.email'),
            'phone' => config('irdcrp.contact.phone'),
            'logo' => config('irdcrp.logos.irdcrp'),
        ];

        if (! Schema::hasTable('site_settings')) {
            return $defaults;
        }

        $saved = Cache::rememberForever('irdcrp.site_settings.footer', function (): array {
            return SiteSetting::query()
                ->whereIn('key', array_map(fn (string $key): string => "footer.$key", self::FOOTER_KEYS))
                ->pluck('value', 'key')
                ->mapWithKeys(fn (?string $value, string $key): array => [str_replace('footer.', '', $key) => $value])
                ->all();
        });

        return array_merge($defaults, array_filter($saved, fn ($value): bool => filled($value)));
    }

    public function putFooter(array $footer): void
    {
        foreach (self::FOOTER_KEYS as $key) {
            SiteSetting::query()->updateOrCreate(
                ['key' => "footer.$key"],
                ['value' => $footer[$key] ?? null],
            );
        }

        Cache::forget('irdcrp.site_settings.footer');
    }

    public function deleteStoredFooterLogo(?string $path): void
    {
        if (! $path || ! Str::startsWith($path, 'storage/footer-logos/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($path, 'storage/'));
    }

    public function aboutPageDefaults(): array
    {
        return config('irdcrp.about_page', []);
    }

    public function aboutPageForAdmin(): array
    {
        $defaults = $this->aboutPageDefaults();
        $saved = $this->savedAboutPage();

        return array_replace_recursive($defaults, $saved);
    }

    public function aboutPageForPublic(): array
    {
        $defaults = $this->aboutPageDefaults();
        $saved = $this->savedAboutPage();

        if (($saved['status'] ?? 'draft') !== 'published') {
            return $defaults;
        }

        return array_replace_recursive($defaults, $saved);
    }

    public function putAboutPage(array $about): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'about_page'],
            ['value' => json_encode($about, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.about_page');
    }

    private function savedAboutPage(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.about_page', function (): ?string {
            return SiteSetting::query()->where('key', 'about_page')->value('value');
        });

        if (! filled($json)) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }
}
