<?php

namespace App\Support;

use App\Models\ProjectAreaDistrict;
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

    public function homeIdentityDefaults(): array
    {
        return [
            'eyebrow' => 'Project identity',
            'title' => 'Integrated Rurban Development and Climate Resilience Project',
            'paragraphs' => [
                'The Integrated Rurban Development and Climate Resilience Project builds on current and recently closed World Bank-financed operations and other sector engagements designed to rapidly address pressing development challenges, especially as Sri Lanka recovers from the economic crisis. It is the first in a Series of Projects (SOP), envisioning two projects over a nine-year period, that incorporates learning and institutional development for multisector solutions and adjusts the implementation approach as needed across projects.',
                'The World Bank and IFC are collaborating to create an enabling environment for smallholder producers to link with commercial buyers and financial institutions, with IFC providing complementary technical assistance to the sector to enhance service delivery.',
                'The SOP will deepen investments in the enabling environment, boost market links, and invest in coordinated efforts for climate resilience to bring greater competitiveness and private sector engagement in the agriculture, livestock, plantation, and aquaculture sectors.',
                'This will support Sri Lanka\'s objectives of increasing agriculture exports and ensuring a sustainable and climate-resilient agri-food production system with improved coordination among a number of departments and agencies.',
            ],
            'badges' => [
                'Climate resilience',
                'Rurban development',
                'Smallholder value chains',
            ],
            'names' => [
                'si' => config('irdcrp.project_name.si'),
                'ta' => config('irdcrp.project_name.ta'),
                'en' => config('irdcrp.project_name.en', 'Integrated Rurban Development and Climate Resilience Project'),
            ],
        ];
    }

    public function homeIdentityForAdmin(): array
    {
        $defaults = $this->homeIdentityDefaults();
        $saved = $this->savedHomeIdentity();
        $identity = array_replace($defaults, $saved);
        $identity['names'] = array_replace(
            $defaults['names'],
            is_array($saved['names'] ?? null) ? $saved['names'] : [],
        );

        return $this->normalizeHomeIdentity($identity);
    }

    public function homeIdentityForPublic(): array
    {
        return $this->homeIdentityForAdmin();
    }

    public function putHomeIdentity(array $identity): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'home_identity'],
            ['value' => json_encode($this->normalizeHomeIdentity($identity), JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.home_identity');
    }

    public function cercPageDefaults(): array
    {
        return [
            'hero_eyebrow' => 'Resources',
            'hero_title' => 'Contingent Emergency Response Component (CERC)',
            'hero_lead' => 'A zero-allocation component that enables rapid project support when an eligible crisis or emergency is declared.',
            'summary_label' => 'Emergency readiness',
            'summary_copy' => 'CERC helps IRDCRP respond quickly to natural or man-made disasters and other eligible emergencies that may cause significant economic or social impacts.',
            'document_section_title' => 'CERC document library',
            'document_section_description' => 'Official CERC guidelines, forms, reports, and emergency response documents available for public download.',
        ];
    }

    public function cercPage(): array
    {
        $defaults = $this->cercPageDefaults();

        if (! Schema::hasTable('site_settings')) {
            return $defaults;
        }

        $json = Cache::rememberForever('irdcrp.site_settings.cerc_page', function (): ?string {
            return SiteSetting::query()->where('key', 'cerc_page')->value('value');
        });

        if (! filled($json)) {
            return $defaults;
        }

        $saved = json_decode($json, true);

        return is_array($saved) ? array_replace($defaults, $saved) : $defaults;
    }

    public function putCercPage(array $settings): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'cerc_page'],
            ['value' => json_encode(array_replace($this->cercPageDefaults(), $settings), JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.cerc_page');
    }

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
        $districtRows = $this->projectAreaDistrictRowsForPublic();

        if (! Schema::hasTable('site_settings')) {
            $defaults['table_rows'] = $districtRows;

            return $defaults;
        }

        $json = Cache::rememberForever('irdcrp.site_settings.project_areas', function (): ?string {
            return SiteSetting::query()->where('key', 'project_areas')->value('value');
        });

        if (! filled($json)) {
            $defaults['table_rows'] = $districtRows;

            return $defaults;
        }

        $saved = json_decode($json, true);

        if (! is_array($saved)) {
            $defaults['table_rows'] = $districtRows;

            return $defaults;
        }

        $projectAreas = array_replace($defaults, $saved);
        $projectAreas['table_headings'] = array_replace(
            $defaults['table_headings'],
            is_array($saved['table_headings'] ?? null) ? $saved['table_headings'] : [],
        );
        $projectAreas['summary'] = is_array($saved['summary'] ?? null) ? $saved['summary'] : $defaults['summary'];
        $projectAreas['table_rows'] = $districtRows;

        return $projectAreas;
    }

    /**
     * @return list<array{district: string, ds_divisions: string, focus: string}>
     */
    public function projectAreaDistrictRowsForPublic(): array
    {
        if (Schema::hasTable('project_area_districts')) {
            $districts = ProjectAreaDistrict::query()
                ->orderedForDisplay()
                ->get();

            if ($districts->isNotEmpty()) {
                return $districts
                    ->map(fn (ProjectAreaDistrict $district): array => $district->toTableRow())
                    ->values()
                    ->all();
            }
        }

        $saved = [];

        if (Schema::hasTable('site_settings')) {
            $json = SiteSetting::query()->where('key', 'project_areas')->value('value');

            if (filled($json)) {
                $decoded = json_decode($json, true);
                $saved = is_array($decoded['table_rows'] ?? null) ? $decoded['table_rows'] : [];
            }
        }

        if ($saved !== []) {
            return $saved;
        }

        return $this->projectAreasDefaults()['table_rows'];
    }

    /**
     * @return \Illuminate\Support\Collection<int, ProjectAreaDistrict>
     */
    public function projectAreaDistrictsForAdmin()
    {
        if (! Schema::hasTable('project_area_districts')) {
            return collect();
        }

        return ProjectAreaDistrict::query()
            ->orderBy('sort_order')
            ->orderBy('district')
            ->get();
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

    public function organizationalStructureDefaults(): array
    {
        return [
            'section_title' => 'Organizational Structure',
            'section_subtitle' => 'Project implementation and reporting structure.',
            'image' => null,
            'image_alt' => 'IRDCRP organizational structure',
            'staff_fallback_image' => null,
            'staff_fallback_image_alt' => 'IRDCRP project staff',
        ];
    }

    public function organizationalStructure(): array
    {
        $defaults = $this->organizationalStructureDefaults();

        if (! Schema::hasTable('site_settings')) {
            return $defaults;
        }

        $json = Cache::rememberForever('irdcrp.site_settings.organizational_structure', function (): ?string {
            return SiteSetting::query()->where('key', 'organizational_structure')->value('value');
        });

        if (! filled($json)) {
            return $defaults;
        }

        $saved = json_decode($json, true);

        return is_array($saved) ? array_replace($defaults, $saved) : $defaults;
    }

    public function putOrganizationalStructure(array $structure): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'organizational_structure'],
            ['value' => json_encode(array_replace($this->organizationalStructureDefaults(), $structure), JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.organizational_structure');
    }

    public function deleteStoredOrganizationalStructureImage(?string $path): void
    {
        if (! $path || ! Str::startsWith($path, 'storage/organizational-structure/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($path, 'storage/'));
    }

    public function organizationalStructureImageUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        return asset(ltrim($path, '/'));
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

    /**
     * @return array<string, mixed>
     */
    public function contactPageDefaults(): array
    {
        $contact = config('irdcrp.contact', []);
        $location = is_array($contact['location'] ?? null) ? $contact['location'] : [];

        return [
            'emails' => array_values(array_filter([
                $contact['email'] ?? null,
                'irdcrp_moa@agrimin.gov.lk',
            ])),
            'phone' => (string) ($contact['phone'] ?? ''),
            'fax' => '011 2073 044',
            'website_url' => 'https://www.irdcrp.lk',
            'website_label' => 'www.irdcrp.lk',
            'address' => (string) ($contact['address'] ?? ''),
            'form_title' => 'Drop us a message for any query',
            'form_subtitle' => 'If you have an idea, we would love to hear about it.',
            'location' => $location,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function contactPageForAdmin(): array
    {
        $defaults = $this->contactPageDefaults();
        $saved = $this->savedContactPage();

        $page = array_replace_recursive($defaults, $saved);
        $page['emails'] = array_values(array_filter(
            is_array($page['emails'] ?? null) ? $page['emails'] : [],
            fn ($email): bool => filled($email),
        ));

        return $page;
    }

    /**
     * @return array<string, mixed>
     */
    public function contactPageForPublic(): array
    {
        return $this->contactPageForAdmin();
    }

    /**
     * @param  array<string, mixed>  $contactPage
     */
    public function putContactPage(array $contactPage): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'contact_page'],
            ['value' => json_encode($contactPage, JSON_UNESCAPED_UNICODE)],
        );

        Cache::forget('irdcrp.site_settings.contact_page');
    }

    public function contactLocationImageUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        if (Str::startsWith($path, ['images/', '/images/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    public function deleteStoredContactLocationImage(?string $path): void
    {
        if (! filled($path) || Str::startsWith($path, ['images/', '/images/'])) {
            return;
        }

        $storagePath = Str::startsWith($path, 'storage/')
            ? Str::after($path, 'storage/')
            : ltrim($path, '/');

        Storage::disk('public')->delete($storagePath);
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

    private function savedHomeIdentity(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.home_identity', function (): ?string {
            return SiteSetting::query()->where('key', 'home_identity')->value('value');
        });

        if (! filled($json)) {
            return [];
        }

        $decoded = json_decode($json, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function normalizeHomeIdentity(array $identity): array
    {
        $defaults = $this->homeIdentityDefaults();
        $paragraphs = $identity['paragraphs'] ?? $defaults['paragraphs'];
        $badges = $identity['badges'] ?? $defaults['badges'];
        $names = is_array($identity['names'] ?? null) ? $identity['names'] : [];

        return [
            'eyebrow' => filled($identity['eyebrow'] ?? null) ? (string) $identity['eyebrow'] : $defaults['eyebrow'],
            'title' => filled($identity['title'] ?? null) ? (string) $identity['title'] : $defaults['title'],
            'paragraphs' => collect(is_array($paragraphs) ? $paragraphs : [])
                ->map(fn ($paragraph): string => trim((string) $paragraph))
                ->filter(fn (string $paragraph): bool => filled($paragraph))
                ->values()
                ->all() ?: $defaults['paragraphs'],
            'badges' => collect(is_array($badges) ? $badges : [])
                ->map(fn ($badge): string => trim((string) $badge))
                ->filter(fn (string $badge): bool => filled($badge))
                ->values()
                ->all() ?: $defaults['badges'],
            'names' => [
                'si' => filled($names['si'] ?? null) ? (string) $names['si'] : $defaults['names']['si'],
                'ta' => filled($names['ta'] ?? null) ? (string) $names['ta'] : $defaults['names']['ta'],
                'en' => filled($names['en'] ?? null) ? (string) $names['en'] : $defaults['names']['en'],
            ],
        ];
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
     * @return array<string, mixed>
     */
    private function savedContactPage(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        $json = Cache::rememberForever('irdcrp.site_settings.contact_page', function (): ?string {
            return SiteSetting::query()->where('key', 'contact_page')->value('value');
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
