<?php

namespace App\Support;

class SiteModules
{
    /**
     * Pluggable site modules. When disabled: public routes 404, nav hidden, home block hidden, admin card hidden.
     * Content stays in the database — re-enable anytime from Admin → Site modules.
     *
     * @return array<string, array{id: string, label: string, description: string, enabled: bool, public_patterns: list<string>, admin_route: string|null, home_block: string|null}>
     */
    public static function definitions(): array
    {
        $items = [
            [
                'id' => 'news',
                'label' => 'News & Events',
                'description' => 'News articles, events, and the home page news section.',
                'enabled' => true,
                'public_patterns' => ['news', 'news/*'],
                'admin_route' => 'admin.news.index',
                'home_block' => 'news',
            ],
            [
                'id' => 'programmes',
                'label' => 'Programmes',
                'description' => 'Programme pages and home page programme cards.',
                'enabled' => true,
                'public_patterns' => ['programmes', 'programmes/*'],
                'admin_route' => 'admin.programmes.index',
                'home_block' => 'programmes',
            ],
            [
                'id' => 'gallery',
                'label' => 'Gallery',
                'description' => 'Photo, video, and media gallery sections.',
                'enabled' => true,
                'public_patterns' => ['gallery', 'gallery/*'],
                'admin_route' => 'admin.gallery.index',
                'home_block' => 'gallery',
            ],
            [
                'id' => 'vacancies',
                'label' => 'Vacancies',
                'description' => 'Job vacancy notices, PDFs, and home page vacancy cards.',
                'enabled' => true,
                'public_patterns' => ['vacancies', 'vacancies/*'],
                'admin_route' => 'admin.vacancies.index',
                'home_block' => 'vacancies',
            ],
            [
                'id' => 'procurement',
                'label' => 'Procurement',
                'description' => 'Procurement notices under Announcements.',
                'enabled' => true,
                'public_patterns' => ['procurement', 'procurement/*'],
                'admin_route' => 'admin.procurement-notices.index',
                'home_block' => null,
            ],
            [
                'id' => 'other_announcements',
                'label' => 'Other announcements',
                'description' => 'General notices under Announcements → Other.',
                'enabled' => true,
                'public_patterns' => ['announcements/other', 'announcements/other/*'],
                'admin_route' => 'admin.other-announcements.index',
                'home_block' => null,
            ],
            [
                'id' => 'downloads',
                'label' => 'Documents library',
                'description' => 'Public documents / downloads page.',
                'enabled' => true,
                'public_patterns' => ['downloads', 'downloads/*'],
                'admin_route' => 'admin.downloads.index',
                'home_block' => null,
            ],
            [
                'id' => 'reports',
                'label' => 'Reports',
                'description' => 'Published project reports page.',
                'enabled' => true,
                'public_patterns' => ['reports', 'reports/*'],
                'admin_route' => 'admin.reports.index',
                'home_block' => null,
            ],
            [
                'id' => 'institutional_development',
                'label' => 'Capacity Build',
                'description' => 'Institutional development / capacity build resources.',
                'enabled' => true,
                'public_patterns' => ['institutional-development', 'institutional-development/*'],
                'admin_route' => 'admin.institutional-developments.index',
                'home_block' => null,
            ],
            [
                'id' => 'safeguards',
                'label' => 'Safeguard',
                'description' => 'Safeguard screening plans and reports.',
                'enabled' => true,
                'public_patterns' => ['safeguards', 'safeguards/*'],
                'admin_route' => 'admin.safeguards.index',
                'home_block' => null,
            ],
            [
                'id' => 'grm',
                'label' => 'GRM',
                'description' => 'Grievance redress mechanism public form and complaints.',
                'enabled' => true,
                'public_patterns' => ['grm', 'grm/*'],
                'admin_route' => 'admin.grm-complaints.index',
                'home_block' => null,
            ],
            [
                'id' => 'faq',
                'label' => 'FAQ',
                'description' => 'Frequently asked questions page.',
                'enabled' => true,
                'public_patterns' => ['faq', 'faq/*'],
                'admin_route' => 'admin.faqs.index',
                'home_block' => null,
            ],
            [
                'id' => 'contact',
                'label' => 'Contact Us',
                'description' => 'Contact page and support message form.',
                'enabled' => true,
                'public_patterns' => ['contact', 'contact/*'],
                'admin_route' => 'admin.support-messages.index',
                'home_block' => null,
            ],
            [
                'id' => 'latest_insights',
                'label' => 'Latest Insights',
                'description' => 'Field insight cards on the home page.',
                'enabled' => true,
                'public_patterns' => [],
                'admin_route' => 'admin.latest-insights.index',
                'home_block' => 'latest_insights',
            ],
            [
                'id' => 'success_stories',
                'label' => 'Success Stories',
                'description' => 'Farmer success story slider on the home page.',
                'enabled' => true,
                'public_patterns' => [],
                'admin_route' => 'admin.success-stories.index',
                'home_block' => 'success_stories',
            ],
            [
                'id' => 'key_leaders',
                'label' => 'Key Leaders & Org. structure',
                'description' => 'Project governance portraits and organizational structure page.',
                'enabled' => true,
                'public_patterns' => ['organizational-structure', 'p/organizational-structure'],
                'admin_route' => 'admin.key-leaders.index',
                'home_block' => 'key_leaders',
            ],
        ];

        return collect($items)->keyBy('id')->all();
    }

    public function __construct(private SiteSettings $settings)
    {
    }

    public function enabled(string $id): bool
    {
        $definitions = self::definitions();
        if (! isset($definitions[$id])) {
            return true;
        }

        $states = $this->settings->moduleStates();

        if (array_key_exists($id, $states)) {
            return (bool) $states[$id];
        }

        return (bool) ($definitions[$id]['enabled'] ?? true);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function forAdmin(): array
    {
        $definitions = self::definitions();
        $states = $this->settings->moduleStates();

        return collect($definitions)
            ->map(function (array $definition) use ($states): array {
                $id = $definition['id'];

                return array_replace($definition, [
                    'enabled' => array_key_exists($id, $states)
                        ? (bool) $states[$id]
                        : (bool) ($definition['enabled'] ?? true),
                ]);
            })
            ->sortBy('label')
            ->values()
            ->all();
    }

    public function moduleForHomeBlock(string $blockId): ?string
    {
        foreach (self::definitions() as $definition) {
            if (($definition['home_block'] ?? null) === $blockId) {
                return $definition['id'];
            }
        }

        return null;
    }

    public function homeBlockAllowed(string $blockId): bool
    {
        $moduleId = $this->moduleForHomeBlock($blockId);

        if ($moduleId === null) {
            return true;
        }

        return $this->enabled($moduleId);
    }

    /**
     * @return list<string>
     */
    public function disabledPublicPatterns(): array
    {
        $patterns = [];

        foreach (self::definitions() as $definition) {
            if ($this->enabled($definition['id'])) {
                continue;
            }

            foreach ($definition['public_patterns'] as $pattern) {
                $patterns[] = $pattern;
            }
        }

        return $patterns;
    }

    /**
     * @param  array<string, bool>  $states
     */
    public function saveStates(array $states): void
    {
        $allowed = array_keys(self::definitions());
        $payload = [];

        foreach ($allowed as $id) {
            if (array_key_exists($id, $states)) {
                $payload[$id] = (bool) $states[$id];
            }
        }

        $this->settings->putModuleStates($payload);
    }
}
