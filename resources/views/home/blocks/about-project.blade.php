{{-- 2. Project identity: Sinhala / Tamil / English + short lead --}}
@php
    $projectIdentity = $projectIdentity ?? app(\App\Support\SiteSettings::class)->homeIdentityForPublic();
    $identityNames = $projectIdentity['names'] ?? [];
    $identityTitleLines = array_values(array_filter([
        $identityNames['si'] ?? null,
        $identityNames['ta'] ?? null,
        $identityNames['en'] ?? null,
    ], fn ($line) => filled($line)));
@endphp

<section id="about-project" class="irdc-identity-section irdc-reveal-on-scroll irdc-scroll-mt-header">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <div class="irdc-identity-shell">
            <div class="irdc-identity-copy">
                <p class="irdc-identity-eyebrow">{{ $projectIdentity['eyebrow'] ?? __('messages.home_trilingual_eyebrow') }}</p>
                <h2 class="irdc-identity-title">{{ $projectIdentity['title'] ?? 'Integrated Rurban Development and Climate Resilience Project' }}</h2>
                <div class="irdc-identity-lead">
                    @foreach(($projectIdentity['paragraphs'] ?? []) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
                <div class="irdc-identity-badges" aria-label="Project focus areas">
                    @foreach(($projectIdentity['badges'] ?? []) as $badge)
                        <span>{{ $badge }}</span>
                    @endforeach
                </div>
            </div>

            <div class="irdc-identity-names" aria-label="Project name in Sinhala, Tamil, and English">
                @foreach ($identityTitleLines as $line)
                    <article @class([
                        'irdc-identity-name',
                    ])>
                        <span class="irdc-identity-name__lang">
                            {{ $loop->iteration === 1 ? 'Sinhala' : ($loop->iteration === 2 ? 'Tamil' : 'English') }}
                        </span>
                        <p>{{ $line }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
