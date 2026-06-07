<?php

namespace App\Support;

use App\Models\SiteSetting;
use App\Models\WeatherDistrict;
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

    public function projectAreasDefaults(): array
    {
        return [
            'hero_title' => 'Project Areas',
            'hero_subtitle' => 'IRDCRP implementation locations and coverage areas',
            'section_title' => 'Geographical Coverage',
            'section_subtitle' => 'Project districts and intervention areas will be updated based on the official project design.',
            'summary_title' => 'Coverage Summary',
            'summary_image' => null,
            'summary' => [
                ['label' => 'Province', 'value' => 'To be updated'],
                ['label' => 'Districts', 'value' => 'To be updated'],
                ['label' => 'DS Divisions', 'value' => 'To be updated'],
                ['label' => 'Beneficiary Communities', 'value' => 'To be updated'],
            ],
            'table_title' => 'District-wise Areas',
            'table_headings' => [
                'district' => 'District',
                'ds_divisions' => 'DS Divisions',
                'focus' => 'Main Focus',
            ],
            'table_rows' => [
                [
                    'district' => 'To be updated',
                    'ds_divisions' => 'To be updated',
                    'focus' => 'Climate Resilience / Agriculture / Livestock',
                ],
                [
                    'district' => 'To be updated',
                    'ds_divisions' => 'To be updated',
                    'focus' => 'Community Development / Livelihoods',
                ],
                [
                    'district' => 'To be updated',
                    'ds_divisions' => 'To be updated',
                    'focus' => 'Infrastructure / Natural Resources',
                ],
            ],
        ];
    }

    public function projectAreas(): array
    {
        $defaults = $this->projectAreasDefaults();

        if (! Schema::hasTable('site_settings')) {
            return $defaults;
        }

        $json = Cache::rememberForever('irdcrp.site_settings.project_areas', function (): ?string {
            return SiteSetting::query()->where('key', 'project_areas')->value('value');
        });

        if (! filled($json)) {
            return $defaults;
        }

        $saved = json_decode($json, true);

        if (! is_array($saved)) {
            return $defaults;
        }

        $projectAreas = array_replace($defaults, $saved);
        $projectAreas['table_headings'] = array_replace(
            $defaults['table_headings'],
            is_array($saved['table_headings'] ?? null) ? $saved['table_headings'] : [],
        );
        $projectAreas['summary'] = is_array($saved['summary'] ?? null) ? $saved['summary'] : $defaults['summary'];
        $projectAreas['table_rows'] = is_array($saved['table_rows'] ?? null) ? $saved['table_rows'] : $defaults['table_rows'];

        return $projectAreas;
    }

    public function putProjectAreas(array $projectAreas): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'project_areas'],
            ['value' => json_encode($projectAreas, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.project_areas');
    }

    public function deleteStoredProjectAreaImage(?string $path): void
    {
        if (! $path || ! Str::startsWith($path, 'storage/project-areas/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($path, 'storage/'));
    }

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

    public function homePopupDefaults(): array
    {
        return [
            'enabled' => false,
            'image' => null,
            'link_url' => null,
            'alt' => 'Important announcement',
            'updated_at' => null,
        ];
    }

    public function homePopupForAdmin(): array
    {
        return array_replace($this->homePopupDefaults(), $this->savedHomePopup());
    }

    public function homePopupForPublic(): array
    {
        $popup = $this->homePopupForAdmin();

        if (! ($popup['enabled'] ?? false) || ! filled($popup['image'] ?? null)) {
            return $this->homePopupDefaults();
        }

        return $popup;
    }

    public function putHomePopup(array $popup): void
    {
        $payload = array_replace($this->homePopupDefaults(), $popup);
        $payload['updated_at'] = now()->toIso8601String();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_popup'],
            ['value' => json_encode($payload, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.home_popup');
    }

    public function homePopupImageUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    public function deleteStoredHomePopupImage(?string $path): void
    {
        if (! $path || ! Str::startsWith($path, 'storage/home-popup/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($path, 'storage/'));
    }

    /**
     * @return array{slide_interval_seconds: int}
     */
    public function homeHeroSliderDefaults(): array
    {
        return [
            'slide_interval_seconds' => 10,
        ];
    }

    /**
     * @return array{slide_interval_seconds: int}
     */
    public function homeHeroSlider(): array
    {
        return array_replace($this->homeHeroSliderDefaults(), $this->savedHomeHeroSlider());
    }

    public function homeHeroSlideIntervalMs(): int
    {
        $seconds = (int) ($this->homeHeroSlider()['slide_interval_seconds'] ?? 10);

        return max(3, min(60, $seconds)) * 1000;
    }

    /**
     * @param  array{slide_interval_seconds?: int}  $settings
     */
    public function putHomeHeroSlider(array $settings): void
    {
        $payload = array_replace($this->homeHeroSliderDefaults(), $settings);
        $payload['slide_interval_seconds'] = max(3, min(60, (int) ($payload['slide_interval_seconds'] ?? 10)));

        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_hero_slider'],
            ['value' => json_encode($payload, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.home_hero_slider');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function homeBlocksForAdmin(): array
    {
        return HomePageBlocks::mergeSaved($this->savedHomeBlocks());
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function homeBlocksForPublic(): array
    {
        $modules = app(SiteModules::class);

        return collect($this->homeBlocksForAdmin())
            ->filter(function (array $block) use ($modules): bool {
                if (! ($block['enabled'] ?? true)) {
                    return false;
                }

                return $modules->homeBlockAllowed((string) ($block['id'] ?? ''));
            })
            ->sortBy('sort_order')
            ->values()
            ->all();
    }

    /**
     * @param  list<array<string, mixed>>  $blocks
     */
    public function putHomeBlocks(array $blocks): void
    {
        $payload = collect($blocks)
            ->map(fn (array $block): array => [
                'id' => (string) ($block['id'] ?? ''),
                'enabled' => (bool) ($block['enabled'] ?? true),
                'sort_order' => (int) ($block['sort_order'] ?? 0),
            ])
            ->filter(fn (array $block): bool => filled($block['id']))
            ->values()
            ->all();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_blocks'],
            ['value' => json_encode($payload, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.home_blocks');
    }

    /**
     * @return array<string, bool>
     */
    public function moduleStates(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.modules', function (): ?string {
            return SiteSetting::query()->where('key', 'site_modules')->value('value');
        });

        if (! filled($json)) {
            return [];
        }

        $decoded = json_decode($json, true);

        if (! is_array($decoded)) {
            return [];
        }

        return collect($decoded)
            ->mapWithKeys(fn ($enabled, $id): array => [(string) $id => (bool) $enabled])
            ->all();
    }

    /**
     * @param  array<string, bool>  $states
     */
    public function putModuleStates(array $states): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'site_modules'],
            ['value' => json_encode($states, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.modules');
    }

    private function savedHomeBlocks(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.home_blocks', function (): ?string {
            return SiteSetting::query()->where('key', 'home_blocks')->value('value');
        });

        if (! filled($json)) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function savedHomePopup(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.home_popup', function (): ?string {
            return SiteSetting::query()->where('key', 'home_popup')->value('value');
        });

        if (! filled($json)) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @return array<string, mixed>
     */
    private function savedHomeHeroSlider(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.home_hero_slider', function (): ?string {
            return SiteSetting::query()->where('key', 'home_hero_slider')->value('value');
        });

        if (! filled($json)) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
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

    /**
     * @return array{default_image: string|null}
     */
    public function weatherDefaults(): array
    {
        return [
            'default_image' => null,
        ];
    }

    /**
     * @return array{default_image: string|null}
     */
    public function weatherSettings(): array
    {
        return array_replace($this->weatherDefaults(), $this->savedWeatherSettings());
    }

    public function weatherDefaultImageUrl(): string
    {
        $path = $this->weatherSettings()['default_image'] ?? null;

        if (! filled($path)) {
            return asset(config('irdcrp.weather_default_image'));
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function weatherAreasForPublic(): array
    {
        if (Schema::hasTable('weather_districts')) {
            $districts = WeatherDistrict::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name_en')
                ->get();

            if ($districts->isNotEmpty()) {
                return $districts
                    ->map(fn (WeatherDistrict $district): array => $district->toWidgetArea())
                    ->values()
                    ->all();
            }
        }

        $areas = config('irdcrp.weather_areas', []);

        return is_array($areas) ? $areas : [];
    }

    /**
     * @return array<string, mixed>
     */
    public function weatherWidget(string $locale): array
    {
        return [
            'areas' => $this->weatherAreasForPublic(),
            'locale' => $locale,
            'defaultImage' => $this->weatherDefaultImageUrl(),
            'condLabels' => [
                'clear' => __('messages.weather_cond_clear'),
                'cloudy' => __('messages.weather_cond_cloudy'),
                'fog' => __('messages.weather_cond_fog'),
                'drizzle' => __('messages.weather_cond_drizzle'),
                'rain' => __('messages.weather_cond_rain'),
                'snow' => __('messages.weather_cond_snow'),
                'thunder' => __('messages.weather_cond_thunder'),
            ],
            'strings' => [
                'loading' => __('messages.weather_loading'),
                'error' => __('messages.weather_error'),
                'forecast' => __('messages.weather_forecast_title'),
                'weather' => __('messages.weather_short'),
                'districts' => __('messages.weather_districts_label'),
            ],
        ];
    }

    /**
     * @param  array{default_image?: string|null}  $settings
     */
    public function putWeatherSettings(array $settings): void
    {
        $payload = array_replace($this->weatherDefaults(), $settings);
        $payload['default_image'] = filled($payload['default_image'] ?? null)
            ? (string) $payload['default_image']
            : null;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'weather'],
            ['value' => json_encode($payload, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.weather');
    }

    public function deleteStoredWeatherImage(?string $path): void
    {
        if (! filled($path) || str_starts_with($path, 'images/')) {
            return;
        }

        Storage::disk('public')->delete(ltrim($path, '/'));
    }

    /**
     * @return array{default_image: string|null}
     */
    private function savedWeatherSettings(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.weather', function (): ?string {
            return SiteSetting::query()->where('key', 'weather')->value('value');
        });

        if (! filled($json)) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }
}
