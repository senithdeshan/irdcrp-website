<?php

namespace App\Support;

class HomePageBlocks
{
    /**
     * @return list<array{id: string, label: string, description: string, admin_route: string|null, enabled: bool, sort_order: int}>
     */
    public static function definitions(): array
    {
        return [
            [
                'id' => 'latest_insights',
                'label' => 'Latest Insights',
                'description' => 'Project updates from the field — cards managed under Latest insights.',
                'admin_route' => 'admin.latest-insights.index',
                'enabled' => true,
                'sort_order' => 10,
            ],
            [
                'id' => 'key_leaders',
                'label' => 'Project Governance / Key Leaders',
                'description' => 'Leadership portraits and project staff preview.',
                'admin_route' => 'admin.key-leaders.index',
                'enabled' => true,
                'sort_order' => 20,
            ],
            [
                'id' => 'programmes',
                'label' => 'Programmes',
                'description' => 'Published programme cards from the Programmes admin.',
                'admin_route' => 'admin.programmes.index',
                'enabled' => true,
                'sort_order' => 30,
            ],
            [
                'id' => 'about_project',
                'label' => 'Project identity',
                'description' => 'Trilingual project name and introduction text.',
                'admin_route' => 'admin.home-identity.edit',
                'enabled' => true,
                'sort_order' => 40,
            ],
            [
                'id' => 'impact_metrics',
                'label' => 'Impact metrics',
                'description' => 'Resilience in numbers — districts, beneficiaries, investment.',
                'admin_route' => 'admin.impact-metrics.index',
                'enabled' => true,
                'sort_order' => 50,
            ],
            [
                'id' => 'weather',
                'label' => 'Weather widget',
                'description' => 'District weather forecast card.',
                'admin_route' => null,
                'enabled' => true,
                'sort_order' => 60,
            ],
            [
                'id' => 'success_stories',
                'label' => 'Success stories',
                'description' => 'Farmer testimonial slider.',
                'admin_route' => 'admin.success-stories.index',
                'enabled' => true,
                'sort_order' => 70,
            ],
            [
                'id' => 'media',
                'label' => 'Krushi TV & video',
                'description' => 'Home video cards from Home videos admin.',
                'admin_route' => 'admin.home-videos.index',
                'enabled' => true,
                'sort_order' => 80,
            ],
            [
                'id' => 'news',
                'label' => 'News & events',
                'description' => 'Latest published news articles.',
                'admin_route' => 'admin.news.index',
                'enabled' => true,
                'sort_order' => 90,
            ],
            [
                'id' => 'gallery',
                'label' => 'Gallery preview',
                'description' => 'Recent photo gallery tiles.',
                'admin_route' => 'admin.gallery.index',
                'enabled' => true,
                'sort_order' => 100,
            ],
            [
                'id' => 'vacancies',
                'label' => 'Vacancies & notices',
                'description' => 'Open vacancy cards — same style as public vacancies page.',
                'admin_route' => 'admin.vacancies.index',
                'enabled' => true,
                'sort_order' => 110,
            ],
            [
                'id' => 'project_partners',
                'label' => 'Project partners',
                'description' => 'Stakeholder logos with website links — shown above the footer.',
                'admin_route' => 'admin.project-partners.index',
                'enabled' => true,
                'sort_order' => 120,
            ],
        ];
    }

    public static function viewName(string $id): string
    {
        return str_replace('_', '-', $id);
    }

    /**
     * @param  list<array<string, mixed>>  $saved
     * @return list<array<string, mixed>>
     */
    public static function mergeSaved(array $saved): array
    {
        $defaults = collect(self::definitions())->keyBy('id');
        $merged = [];

        foreach ($saved as $row) {
            $id = (string) ($row['id'] ?? '');
            if (! $defaults->has($id)) {
                continue;
            }

            $merged[] = array_replace($defaults[$id], [
                'enabled' => (bool) ($row['enabled'] ?? true),
                'sort_order' => (int) ($row['sort_order'] ?? $defaults[$id]['sort_order']),
            ]);
        }

        $seen = collect($merged)->pluck('id')->all();

        foreach ($defaults as $id => $block) {
            if (! in_array($id, $seen, true)) {
                $merged[] = $block;
            }
        }

        return collect($merged)
            ->sortBy('sort_order')
            ->values()
            ->all();
    }
}
