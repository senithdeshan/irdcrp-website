@extends('layouts.app')

@section('title', __('messages.site_page_title_home'))
@section('meta_description', __('messages.site_meta_description'))

@php
    $slides = config('irdcrp.hero_slides', []);
    $names = config('irdcrp.project_name', []);
    $heroLoc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
    $heroTitle = filled($names[$heroLoc] ?? null) ? $names[$heroLoc] : ($names['en'] ?? 'Integrated Rurban Development and Climate Resilience Project');
    $titleLines = array_values(array_filter(
        [($names['si'] ?? null) ?: null, ($names['ta'] ?? null) ?: null, ($names['en'] ?? null) ?: null],
        fn ($l) => filled($l)
    ));
    if ($titleLines === []) {
        $titleLines = [$names['en'] ?? 'Integrated Rurban Development and Climate Resilience Project'];
    }
    if ($latestNews ?? null) {
        $loc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
        $latestTitle = $latestNews->{'title_'.$loc} ?? $latestNews->title_en;
    } else {
        $latestTitle = null;
    }
    $firstCaption = (isset($slides[0]) ? ($slides[0]['caption_en'] ?? '') : '');
    $programmes = $programmes ?? collect();
    $ytConfig = config('irdcrp.youtube', []);
    $ytChannel = $ytConfig['channel_url'] ?? 'https://www.youtube.com/';
    $ytIds = $ytConfig['embed_ids'] ?? [];
    $firstVideo = $ytIds[0] ?? null;
    $tLoc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
    $stats = config('irdcrp.home_stats', []);
    $impactMetrics = ($impactMetrics ?? collect())->isNotEmpty()
        ? $impactMetrics
        : collect([
            (object) ['key' => 'districts', 'label' => 'Districts', 'value' => '11', 'count_target' => 11, 'helper' => 'Implementation districts across Sri Lanka'],
            (object) ['key' => 'beneficiaries', 'label' => 'Total Beneficiaries', 'value' => '57,500', 'count_target' => 57500, 'helper' => 'People expected to benefit from project interventions'],
            (object) ['key' => 'investment', 'label' => 'Total Investment', 'value' => $stats['investment'] ?? 'USD 105 Million', 'count_target' => null, 'helper' => 'Financing envelope for resilient agriculture development'],
            (object) ['key' => 'projects', 'label' => 'Total Projects', 'value' => $stats['projects'] ?? '34', 'count_target' => is_numeric($stats['projects'] ?? null) ? (int) $stats['projects'] : 34, 'helper' => 'Priority investments and field-level activities'],
        ]);
    $mapEmbedUrl = config('irdcrp.map_embed_url');
    $successStories = $successStories ?? collect();
    $programmeCards = collect(config('irdcrp.programme_cards', []));
    $weatherAreas = config('irdcrp.weather_areas', []);
    if (! is_array($weatherAreas) || $weatherAreas === []) {
        $weatherAreas = [
            ['id' => 'ampara', 'lat' => 7.297, 'lon' => 81.679, 'name' => ['en' => 'Ampara', 'si' => 'අම්පාර', 'ta' => 'அம்பாறை']],
        ];
    }
    $weatherWidget = [
        'areas' => $weatherAreas,
        'locale' => $tLoc,
        'defaultImage' => asset(config('irdcrp.weather_default_image')),
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
@endphp

@section('content')
<div id="top"></div>

<section
    x-data="{
        i: 0,
        n: 1,
        slides: @js($slides),
        prev() { this.i = (this.i - 1 + this.n) % this.n; },
        next() { this.i = (this.i + 1) % this.n; },
    }"
    x-init="n = Math.max(slides && slides.length ? slides.length : 0, 1); if (slides && slides.length > 1) { setInterval(() => { i = (i + 1) % n }, 7500) }"
    class="irdc-hero irdc-hero--with-fixed-nav relative min-h-[100svh] min-h-screen overflow-hidden text-white"
>
    <div class="absolute inset-0 min-h-[100svh] min-h-screen">
        <template x-for="(s, idx) in slides" :key="idx">
            <div
                x-show="slides.length && i === idx"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="irdc-hero-bg-layer absolute inset-0 min-h-full bg-center bg-cover"
                :style="`background-image: url('${s.image}')`"
            ></div>
        </template>
        @if(count($slides) === 0)
            <div
                class="irdc-hero-bg-layer absolute inset-0 min-h-full bg-center bg-cover"
                style="background-image: url('{{ asset('images/hero/hero-home-01.png') }}');"
            ></div>
        @endif
        <div class="irdc-hero__veil absolute inset-0 min-h-full" aria-hidden="true"></div>
    </div>

    {{-- Header offset on this wrapper (not the centered inner) so flex justify-center runs only in the band below the fixed nav --}}
    <div class="relative z-10 box-border flex min-h-[100svh] min-h-screen flex-col pt-[var(--irdc-header-offset)]">
        <div class="irdc-hero-anim irdc-hero-stagger mx-auto flex w-full max-w-7xl flex-1 flex-col justify-center px-3 pb-44 text-center sm:px-5 sm:pb-48 lg:px-8">
            <p class="irdc-hero__eyebrow irdc-hero-stagger__item">{{ __('messages.hero_eyebrow') }}</p>
            <h1 class="irdc-hero__title irdc-hero-stagger__item mt-6 sm:mt-7">
                {{ $heroTitle }}
            </h1>
            <p class="irdc-hero__pill-lead irdc-hero-stagger__item" data-typing>
                {{ __('messages.home_hero_subtitle') }}
            </p>
            <p
                x-show="slides && slides.length"
                x-text="slides && slides[i] && (slides[i].caption_en || '')"
                x-cloak
                class="irdc-hero__lead irdc-hero-stagger__item"
            ></p>
            <p
                x-show="! slides || slides.length === 0"
                x-cloak
                class="irdc-hero__lead irdc-hero-stagger__item"
            >{{ e($firstCaption) ?: __('messages.hero_caption') }}</p>
            <div class="irdc-hero__actions irdc-hero-stagger__item">
                <a href="/about" class="irdc-hero__btn-primary">
                    {{ __('messages.home_hero_learn') }} <span aria-hidden="true">→</span>
                </a>
                <a href="{{ url('/contact') }}" class="irdc-hero__btn-secondary">
                    {{ __('messages.home_get_involved') }}
                </a>
            </div>
            <a href="#about-project" class="irdc-hero__scroll irdc-hero-stagger__item">
                <span>{{ __('messages.hero_scroll') }}</span>
                <span class="irdc-hero__scroll-icon" aria-hidden="true"><span></span></span>
            </a>
        </div>

        @if($latestTitle)
            <a
                href="{{ route('news.show', $latestNews) }}"
                class="group hidden max-w-sm rounded-2xl border border-white/20 bg-slate-950/50 p-4 text-left shadow-2xl backdrop-blur-md transition hover:border-emerald-400/30 hover:bg-slate-900/60 sm:absolute sm:bottom-40 sm:right-6 sm:mb-0 sm:block lg:bottom-10"
            >
                <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-300">{{ __('messages.home_news_events') }}</p>
                <p class="mt-1 line-clamp-2 text-sm font-medium text-white">{{ $latestTitle }}</p>
                <p class="mt-2 text-xs text-white/50">{{ __('messages.read_more') }} →</p>
            </a>
        @endif

        <div class="absolute bottom-0 left-0 right-0 z-20 border-t border-white/15 bg-slate-950/55 px-3 py-3.5 backdrop-blur-md sm:px-5 lg:px-8">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
                <div class="flex min-w-0 flex-1 items-center gap-2">
                    <button type="button" @click="prev()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-white/25 text-white transition hover:bg-white/15" aria-label="Previous slide">‹</button>
                    <div x-show="slides && slides.length > 1" x-cloak class="flex flex-1 items-center gap-1.5">
                        <template x-for="(s, idx) in slides" :key="'p' + idx">
                            <button type="button" @click="i = idx" class="h-1.5 min-w-0 flex-1 max-w-14 rounded-full sm:max-w-20 sm:h-2" :class="i === idx ? 'bg-emerald-400' : 'bg-white/20'"></button>
                        </template>
                    </div>
                    <div x-show="! slides || slides.length <= 1" x-cloak class="hidden h-1 w-full max-w-xs rounded-full bg-white/20 sm:block"></div>
                </div>
                <div class="hidden text-xs text-white/45 sm:flex sm:items-center sm:gap-1">
                    <span x-text="(slides && slides.length) ? (i + 1) : 1"></span><span class="text-white/25">/</span><span x-text="(slides && slides.length) || 1"></span>
                </div>
                <button type="button" @click="next()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-white/25 text-white transition hover:bg-white/15" aria-label="Next slide">›</button>
            </div>
        </div>
    </div>

    <div class="irdc-hero-waves pointer-events-none relative z-20 -mb-px text-white" aria-hidden="true">
        <svg viewBox="0 0 1200 72" preserveAspectRatio="none" class="h-8 w-full sm:h-12 md:h-14">
            <path fill="currentColor" d="M0,48 C150,8 300,64 450,32 C600,0 750,40 900,24 C1050,8 1100,32 1200,16 L1200,72 L0,72 Z"/>
        </svg>
    </div>
</section>

{{-- Outside hero: hero section uses overflow:hidden which clips position:fixed children --}}
<aside class="irdc-hero-social" aria-label="{{ __('messages.header_social_aria') }}">
    <a href="{{ config('irdcrp.social.youtube') }}" target="_blank" rel="noopener noreferrer" title="YouTube" class="irdc-hero-social__btn">
        <img src="{{ asset(config('irdcrp.social_icons.youtube')) }}" alt="YouTube" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
    </a>
    <a href="{{ config('irdcrp.social.facebook') }}" target="_blank" rel="noopener noreferrer" title="Facebook" class="irdc-hero-social__btn">
        <img src="{{ asset(config('irdcrp.social_icons.facebook')) }}" alt="Facebook" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
    </a>
    <a href="{{ config('irdcrp.social.twitter') }}" target="_blank" rel="noopener noreferrer" title="X" class="irdc-hero-social__btn">
        <img src="{{ asset(config('irdcrp.social_icons.twitter')) }}" alt="X" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
    </a>
    <a href="{{ config('irdcrp.social.linkedin') }}" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="irdc-hero-social__btn">
        <img src="{{ asset(config('irdcrp.social_icons.linkedin')) }}" alt="LinkedIn" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
    </a>
    <a href="{{ config('irdcrp.social.instagram') }}" target="_blank" rel="noopener noreferrer" title="Instagram" class="irdc-hero-social__btn">
        <img src="{{ asset(config('irdcrp.social_icons.instagram')) }}" alt="Instagram" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
    </a>
</aside>

{{-- Institutional context — clear for stakeholders & presentations --}}
<div class="border-b border-t border-emerald-950/15 bg-gradient-to-r from-emerald-50 via-white to-cyan-50/80 py-3.5 text-center shadow-sm">
    <p class="mx-auto max-w-7xl px-3 text-xs font-medium leading-relaxed text-slate-700 sm:px-5 sm:text-sm lg:px-8">
        <span class="font-display font-bold text-[#0A3D62]">{{ __('messages.home_trust_gosl') }}</span>
        <span class="mx-1.5 text-slate-300 sm:mx-2" aria-hidden="true">·</span>
        <span>{{ __('messages.home_trust_partners') }}</span>
    </p>
</div>

{{-- Key leaders — first content after hero (always visible; no scroll-reveal fade) --}}
@if(count($keyLeaders) > 0)
    <section id="key-leaders" class="irdc-leaders-section irdc-scroll-mt-header" aria-labelledby="key-leaders-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="irdc-leaders-head">
                <p class="irdc-leaders-eyebrow">Project Governance</p>
                <div class="irdc-leaders-title-row">
                    <h2 id="key-leaders-heading" class="irdc-leaders-title">
                        {{ __('messages.home_leaders_title') }}
                    </h2>
                    <span class="irdc-leaders-leaf" aria-hidden="true">
                        <svg class="h-7 w-7 sm:h-8 sm:w-8" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 22c-2-6 2-14 10-16 2 8-2 14-10 16Z" fill="currentColor" opacity="0.35"/>
                            <path d="M14 24c8-2 12-10 10-18-8 2-12 10-10 18Z" fill="currentColor"/>
                        </svg>
                    </span>
                </div>
                <p class="irdc-leaders-subtitle">
                    Leadership and institutional coordination for implementation, supervision, and partner collaboration.
                </p>
            </header>
            <div class="irdc-leaders-grid">
                @foreach ($keyLeaders as $leader)
                    @php
                        if ($leader instanceof \App\Models\KeyLeader) {
                            $portrait = $leader->image
                                ? asset('storage/'.$leader->image)
                                : asset('images/hero/hero-home-02.png');
                            $roleLabel = $leader->label('role', $tLoc);
                            $orgLabel = $leader->label('org', $tLoc);
                        } else {
                            $imgPath = ltrim($leader['image'] ?? '', '/');
                            $portraitPath = isset($leader['image']) && is_file(public_path($imgPath))
                                ? $leader['image']
                                : ($leader['fallback'] ?? '/images/hero/hero-home-01.png');
                            $portrait = str_starts_with($portraitPath, 'http')
                                ? $portraitPath
                                : asset(ltrim($portraitPath, '/'));
                            $roleKey = $leader['role'] ?? '';
                            $orgKey = $leader['org'] ?? '';
                            $roleLabel = $roleKey ? __('messages.'.$roleKey) : '';
                            $orgLabel = $orgKey ? __('messages.'.$orgKey) : '';
                        }
                    @endphp
                    <article class="irdc-leader-card">
                        <span class="irdc-leader-card__index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="irdc-leader-card__photo">
                            <img
                                src="{{ $portrait }}"
                                alt="{{ __('messages.leader_photo_alt', ['role' => $roleLabel]) }}"
                                width="280"
                                height="280"
                                loading="lazy"
                                decoding="async"
                                class="irdc-leader-card__img"
                            >
                        </div>
                        <div class="irdc-leader-card__content">
                            @if(filled($roleLabel))
                                <h3 class="irdc-leader-card__role">{{ $roleLabel }}</h3>
                            @endif
                            @if(filled($orgLabel))
                                <p class="irdc-leader-card__org">{{ $orgLabel }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- 2. Programmes --}}
<section id="programmes" class="irdc-home-programmes irdc-reveal-on-scroll irdc-scroll-mt-header">
    <div class="mx-auto max-w-[118rem] px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <header class="irdc-home-programmes__head">
            <p class="irdc-home-programmes__eyebrow">{{ __('messages.home_programmes_eyebrow') }}</p>
            <h2 class="irdc-home-programmes__title">{{ __('messages.home_programmes_title') }}</h2>
            <p class="irdc-home-programmes__lead">{{ __('messages.home_programmes_sub') }}</p>
        </header>
        <div class="irdc-programmes-grid irdc-programmes-grid--home">
            @if($programmes->isNotEmpty())
                @foreach($programmes as $programme)
                    <a
                        href="{{ route('programmes.show', $programme) }}"
                        class="irdc-programme-card group"
                    >
                        <div class="irdc-programme-card__image">
                            <img
                                src="{{ str_starts_with($programme->image ?? '', 'images/') ? asset($programme->image) : asset('storage/'.$programme->image) }}"
                                alt="{{ $programme->title }}"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <div class="irdc-programme-card__body">
                            <h3 class="irdc-programme-card__title">{{ $programme->title }}</h3>
                            @if($programme->summary)
                                <p class="irdc-programme-card__summary">{{ $programme->summary }}</p>
                            @endif
                            <span class="irdc-programme-card__cta">Explore programme</span>
                        </div>
                    </a>
                @endforeach
            @elseif($programmeCards->isNotEmpty())
                @foreach($programmeCards as $card)
                    @php
                        $cardId = (string) ($card['id'] ?? '');
                        $cardSummaryKey = $cardId !== '' ? 'messages.prog_'.$cardId.'_desc' : '';
                        $cardTitle = $cardId !== '' ? __('messages.prog_'.$cardId) : '';
                        $cardSummary = $cardSummaryKey !== '' ? __($cardSummaryKey) : '';
                        $cardImage = isset($card['image']) ? asset(ltrim((string) $card['image'], '/')) : asset('images/hero/hero-home-01.png');
                    @endphp
                    <article class="irdc-programme-card group">
                        <div class="irdc-programme-card__image">
                            <img
                                src="{{ $cardImage }}"
                                alt="{{ filled($cardTitle) ? $cardTitle : __('messages.nav_programmes') }}"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <div class="irdc-programme-card__body">
                            @if(filled($cardTitle))
                                <h3 class="irdc-programme-card__title">{{ $cardTitle }}</h3>
                            @endif
                            @if(filled($cardSummary) && lang()->has($cardSummaryKey))
                                <p class="irdc-programme-card__summary">{{ $cardSummary }}</p>
                            @endif
                            <span class="irdc-programme-card__cta">Explore programme</span>
                        </div>
                    </article>
                @endforeach
            @else
                <div class="irdc-programmes-empty">Programmes are being updated.</div>
            @endif
        </div>
        <div class="mt-12 text-center">
            <a href="{{ route('programmes.index') }}" class="irdc-home-programmes__link">View all programmes</a>
        </div>
    </div>
</section>

{{-- 2. Project identity: Sinhala / Tamil / English + short lead --}}
<section id="about-project" class="irdc-identity-section irdc-reveal-on-scroll irdc-scroll-mt-header">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <div class="irdc-identity-shell">
            <div class="irdc-identity-copy">
                <p class="irdc-identity-eyebrow">{{ __('messages.home_trilingual_eyebrow') }}</p>
                <h2 class="irdc-identity-title">Integrated Rurban Development and Climate Resilience Project</h2>
                <p class="irdc-identity-lead">
                    A flagship initiative of the Government of Sri Lanka, implemented with the World Bank and partners, to scale climate-resilient "rurban" development - linking smallholders, value chains, and public services across the country. Official figures and results are published as they are validated.
                </p>
                <div class="irdc-identity-badges" aria-label="Project focus areas">
                    <span>Climate resilience</span>
                    <span>Rurban development</span>
                    <span>Smallholder value chains</span>
                </div>
            </div>

            <div class="irdc-identity-names" aria-label="Project name in Sinhala, Tamil, and English">
                @foreach ($titleLines as $line)
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

{{-- 3. Impact / statistics --}}
<section class="hidden">
    <div class="container max-w-6xl">
        <header class="irdc-section-head irdc-section-head--emerald">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_stats_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_stats_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_stats_sub') }}</p>
        </header>
        <div class="mt-10 grid grid-cols-2 gap-4 sm:mt-12 lg:grid-cols-4 lg:gap-6" data-reveal-stagger>
            <article class="irdc-stat-tile">
                @php
                    $districts = (string) ($stats['districts'] ?? '00');
                @endphp
                <p class="font-display text-4xl font-extrabold tabular-nums text-[#0A3D62] sm:text-5xl md:text-6xl lg:text-6xl" data-countup data-target="{{ (int) preg_replace('/\D+/', '', $districts) }}">{{ $districts }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_districts') }}</p>
            </article>
            <article class="irdc-stat-tile">
                @php
                    $beneficiaries = (string) ($stats['beneficiaries'] ?? '00');
                @endphp
                <p class="font-display text-4xl font-extrabold tabular-nums text-emerald-800 sm:text-5xl md:text-6xl lg:text-6xl" data-countup data-target="{{ (int) preg_replace('/\D+/', '', $beneficiaries) }}">{{ $beneficiaries }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_beneficiaries') }}</p>
            </article>
            <article class="irdc-stat-tile">
                @php
                    $farmers = (string) ($stats['farmers'] ?? '00');
                @endphp
                <p class="font-display text-4xl font-extrabold tabular-nums text-[#0A3D62] sm:text-5xl md:text-6xl lg:text-6xl" data-countup data-target="{{ (int) preg_replace('/\D+/', '', $farmers) }}">{{ $farmers }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_farmers') }}</p>
            </article>
            <article class="irdc-stat-tile">
                <p class="font-display text-3xl font-extrabold tabular-nums text-emerald-800 sm:text-4xl md:text-5xl lg:text-6xl">{{ $stats['duration'] ?? '—' }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_duration') }}</p>
            </article>
        </div>
    </div>
</section>

{{-- 3b. Weather — single modern card (image + district picker + forecast) --}}
<section class="irdc-impact-section irdc-reveal-on-scroll">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <div class="irdc-impact-shell">
            <div class="irdc-impact-intro">
                <p class="irdc-impact-eyebrow">{{ __('messages.home_stats_eyebrow') }}</p>
                <h2 class="irdc-impact-title">Agriculture resilience in numbers</h2>
                <p class="irdc-impact-lead">
                    Key implementation indicators for climate-smart agriculture, value chain support, and resilient rural livelihoods in Sri Lanka.
                </p>
            </div>
            <div class="irdc-impact-grid" data-reveal-stagger>
                @foreach($impactMetrics as $metric)
                    @php
                        $countTarget = (int) ($metric->count_target ?? 0);
                        $displayValue = (string) ($metric->value ?? '');
                    @endphp
                    <article class="irdc-impact-card irdc-impact-card--{{ $metric->key ?? 'metric' }}">
                        <span class="irdc-impact-card__icon" aria-hidden="true">
                            @switch($metric->key ?? '')
                                @case('beneficiaries')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 19c0-2.2-1.8-4-4-4s-4 1.8-4 4"/><path d="M12 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M20 18c0-1.7-1-3.1-2.5-3.7"/><path d="M17 6.4a2.5 2.5 0 0 1 0 4.2"/></svg>
                                    @break
                                @case('investment')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 18V8l8-4 8 4v10"/><path d="M7 18v-6h10v6"/><path d="M3 20h18"/></svg>
                                    @break
                                @case('projects')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/><path d="M8 5v14"/></svg>
                                    @break
                                @default
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 20h16"/><path d="M6 20V9l6-5 6 5v11"/><path d="M9 20v-6h6v6"/></svg>
                            @endswitch
                        </span>
                        <p class="irdc-impact-card__value">
                            @if($countTarget > 0 && preg_match('/^[0-9,]+$/', $displayValue))
                                <span data-countup data-target="{{ $countTarget }}">{{ $displayValue }}</span>
                            @else
                                {{ $displayValue }}
                            @endif
                        </p>
                        <h3 class="irdc-impact-card__label">{{ $metric->label }}</h3>
                        @if(filled($metric->helper))
                            <p class="irdc-impact-card__helper">{{ $metric->helper }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section
    id="weather-areas"
    class="irdc-scroll-mt-header irdc-weather-section relative border-b border-stone-200/80 bg-gradient-to-b from-emerald-50/70 via-[#f8faf8] to-white py-16 sm:py-20 md:py-24"
    x-data="irdcWeather(@js($weatherWidget))"
>
    <span class="irdc-weather-section__blob irdc-weather-section__blob--1" aria-hidden="true"></span>
    <span class="irdc-weather-section__blob irdc-weather-section__blob--2" aria-hidden="true"></span>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="mx-auto mb-10 max-w-4xl text-center sm:mb-12">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800/80 sm:text-sm">{{ __('messages.home_weather_eyebrow') }}</p>
            <h2 class="mt-3 font-display text-2xl font-extrabold leading-snug tracking-tight text-[#3d2f1f] sm:text-3xl md:text-[1.75rem] lg:text-4xl">
                {{ __('messages.home_weather_title') }}
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">{{ __('messages.home_weather_sub') }}</p>
        </header>

        <div class="irdc-weather-mega">
            <div class="irdc-weather-mega__grid">
                {{-- Left: hero photo + organic backdrop --}}
                <div class="irdc-weather-mega__visual">
                    <div class="irdc-weather-mega__visual-blob" aria-hidden="true"></div>
                    <figure class="irdc-weather-deckle irdc-weather-deckle--hero relative z-[1] mx-auto max-w-md lg:mx-0">
                        <img
                            :src="areaImage()"
                            alt="{{ __('messages.home_weather_image_alt') }}"
                            width="520"
                            height="900"
                            loading="lazy"
                            decoding="async"
                            class="min-h-[12rem] w-full bg-stone-100"
                        >
                    </figure>
                </div>

                {{-- Right: embedded widget (districts | forecast) --}}
                <div class="irdc-weather-mega__widget">
                    <div class="irdc-weather-widget-shell">
                        {{-- District list --}}
                        <div class="irdc-weather-widget-shell__districts">
                            <p class="irdc-weather-widget-label" x-text="strings.districts"></p>
                            <div
                                class="irdc-weather-district-list"
                                role="listbox"
                                aria-label="{{ __('messages.weather_districts_label') }}"
                            >
                                <template x-for="(a, idx) in areas" :key="a.id">
                                    <button
                                        type="button"
                                        class="irdc-weather-district-btn"
                                        :class="{ 'irdc-weather-district-btn--active': selected === idx }"
                                        role="option"
                                        :aria-selected="selected === idx ? 'true' : 'false'"
                                        @click="select(idx)"
                                    >
                                        <span x-text="a.name[locale] || a.name.en"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- Forecast --}}
                        <div class="irdc-weather-widget-shell__forecast">
                            <p class="irdc-weather-panel-head">
                                <span class="text-slate-500" x-text="districtLabel()"></span>
                                <span class="text-slate-300">·</span>
                                <span x-text="strings.weather"></span>
                            </p>

                            <div x-show="loading" x-cloak class="irdc-weather-state irdc-weather-state--loading">
                                <span class="h-9 w-9 animate-spin rounded-full border-2 border-[#5a4a1f] border-t-transparent" aria-hidden="true"></span>
                                <span class="mt-3 text-sm text-slate-600" x-text="strings.loading"></span>
                            </div>

                            <div x-show="!loading && error" x-cloak class="irdc-weather-state text-sm text-amber-900/95" role="alert">
                                <span x-text="strings.error"></span>
                            </div>

                            <div x-show="!loading && !error && payload" x-cloak class="irdc-weather-forecast-body">
                                <div class="irdc-weather-current">
                                    <div class="irdc-weather-current__icon" aria-hidden="true">
                                        <svg x-show="iconKind(currentCode()) === 'sun'" class="absolute inset-0 h-full w-full text-amber-500" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><circle cx="32" cy="32" r="14"/><path d="M32 6v6M32 52v6M6 32h6M52 32h6M13.6 13.6l4.2 4.2M46.2 46.2l4.2 4.2M13.6 50.4l4.2-4.2M46.2 17.8l4.2-4.2"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'cloud'" class="absolute inset-0 h-full w-full text-slate-500" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 40h36a10 10 0 0 0 0-20 13 13 0 0 0-25-4 10 10 0 0 0-19 6" fill="currentColor" fill-opacity="0.12"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'rain' || iconKind(currentCode()) === 'drizzle' || iconKind(currentCode()) === 'thunder'" class="absolute inset-0 h-full w-full text-sky-600" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 36h36a9 9 0 0 0 0-18 12 12 0 0 0-23-3 9 9 0 0 0-17 5" fill="currentColor" fill-opacity="0.1"/><path d="M22 46v8M32 44v10M42 46v8" stroke="currentColor"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'snow'" class="absolute inset-0 h-full w-full text-sky-400" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 34h30a8 8 0 0 0 0-16 11 11 0 0 0-21-2 8 8 0 0 0-15 4" fill="currentColor" fill-opacity="0.1"/><path d="m32 42-4 4m4-4 4 4m-4-4v8"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'fog'" class="absolute inset-0 h-full w-full text-slate-400" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 28h40M10 36h44M14 44h36" stroke-linecap="round"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-display text-4xl font-extrabold tabular-nums text-[#3d2f1f] sm:text-5xl">
                                            <span x-text="currentTemp() !== null ? currentTemp() + '°C' : '—'"></span>
                                        </p>
                                        <p class="mt-1.5 text-sm font-medium capitalize text-slate-600" x-text="condLabel(currentCode())"></p>
                                    </div>
                                </div>

                                <div class="irdc-weather-week">
                                    <p class="irdc-weather-week__title" x-text="strings.forecast"></p>
                                    <ul class="irdc-weather-week__list">
                                        <template x-for="row in dailyRows()" :key="row.date">
                                            <li class="irdc-weather-week__row">
                                                <span class="irdc-weather-week__day" x-text="formatDayShort(row.date)"></span>
                                                <span class="irdc-weather-week__ico relative inline-flex h-5 w-5 shrink-0 items-center justify-center" aria-hidden="true">
                                                    <svg x-show="iconKind(row.code) === 'sun'" class="absolute inset-0 m-auto h-5 w-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'cloud'" class="absolute inset-0 m-auto h-5 w-5 text-slate-500" viewBox="0 0 24 24" fill="currentColor" opacity="0.45"><path d="M5 16h12a4 4 0 0 0 0-8 6 6 0 0 0-11-2 4 4 0 0 0-7 3"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'rain' || iconKind(row.code) === 'thunder' || iconKind(row.code) === 'drizzle'" class="absolute inset-0 m-auto h-5 w-5 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 14h11a3.5 3.5 0 0 0 0-7 5 5 0 0 0-9.5-1.5A3.5 3.5 0 0 0 5 14Z" fill="currentColor" fill-opacity="0.15"/><path d="M9 18v3M12 17v4M15 18v3"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'snow'" class="absolute inset-0 m-auto h-5 w-5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 13h10a3 3 0 0 0 0-6 4 4 0 0 0-8-.5A3 3 0 0 0 6 13Z" fill="currentColor" fill-opacity="0.15"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'fog'" class="absolute inset-0 m-auto h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 10h16M3 14h18M5 18h14" stroke-linecap="round"/></svg>
                                                </span>
                                                <span class="irdc-weather-week__hi" x-text="Math.round(row.max) + '°'"></span>
                                                <span class="irdc-weather-week__lo" x-text="Math.round(row.min) + '°'"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                                <p class="irdc-weather-attrib">
                                    <a href="https://open-meteo.com/" rel="noopener noreferrer" target="_blank" class="transition hover:text-slate-700">{{ __('messages.weather_attribution') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. Success stories slider --}}
<section
    class="irdc-success relative overflow-hidden py-20 sm:py-24"
    x-data="{
        stories: @js($successStories),
        i: 0,
        timer: null,
        viewportWidth: 0,
        cardStep() {
            if (window.innerWidth < 640) return 316;
            if (window.innerWidth < 1024) return 388;
            return 430;
        },
        get visible() {
            return Math.max(1, Math.floor(this.viewportWidth / this.cardStep()));
        },
        get pages() {
            return Math.max(this.stories.length - this.visible + 1, 1);
        },
        next() { this.i = (this.i + 1) % this.pages; },
        prev() { this.i = (this.i - 1 + this.pages) % this.pages; },
        goTo(idx) { this.i = idx; },
        cardWidth() { return Math.max(this.cardStep() - 18, 280); },
        start() {
            this.stop();
            if (this.pages > 1) {
                this.timer = setInterval(() => this.next(), 5500);
            }
        },
        stop() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
        syncLayout() {
            this.viewportWidth = this.$refs.viewport ? this.$refs.viewport.clientWidth : window.innerWidth;
            this.i = Math.min(this.i, this.pages - 1);
            this.start();
        }
    }"
    x-init="syncLayout(); window.addEventListener('resize', () => syncLayout())"
    @mouseenter="stop()"
    @mouseleave="start()"
>
    <div class="irdc-success__bg absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-success__overlay absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-success__wave irdc-success__wave--top" aria-hidden="true">
        <svg viewBox="0 0 1200 72" preserveAspectRatio="none" class="h-10 w-full sm:h-12">
            <path fill="currentColor" d="M0,48 C150,8 300,64 450,32 C600,0 750,40 900,24 C1050,8 1100,32 1200,16 L1200,72 L0,72 Z"/>
        </svg>
    </div>
    <div class="irdc-success__wave irdc-success__wave--bottom" aria-hidden="true">
        <svg viewBox="0 0 1200 72" preserveAspectRatio="none" class="h-10 w-full sm:h-12">
            <path fill="currentColor" d="M0,48 C150,8 300,64 450,32 C600,0 750,40 900,24 C1050,8 1100,32 1200,16 L1200,72 L0,72 Z"/>
        </svg>
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="mx-auto mb-10 max-w-3xl text-center sm:mb-12">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-800/80 sm:text-sm">Success Stories</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-[#0A3D62] sm:text-4xl">Farmer Success Stories</h2>
            <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                Real experiences from farming communities supported through climate-resilient livelihoods.
            </p>
        </header>

        <div x-ref="viewport" class="relative overflow-hidden">
            <div
                class="flex gap-4 transition-transform duration-700 ease-out"
                :style="`transform: translateX(-${i * cardStep()}px);`"
            >
                @forelse ($successStories as $story)
                    <article class="shrink-0 pb-2" :style="`width: ${cardWidth()}px`">
                        <div class="irdc-success-card group">
                            <div class="flex min-w-0 items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate text-base font-extrabold text-[#1B5E20] sm:text-lg">{{ $story->name }}</h3>
                                    <p class="truncate text-xs font-bold uppercase tracking-wide text-[#8B4A1F]/95 sm:text-sm">{{ $story->location }} - {{ $story->province }}</p>
                                </div>
                                <span class="irdc-success-quote-top" aria-hidden="true">❝</span>
                            </div>
                            <p class="irdc-success-story-text mt-3 text-sm leading-relaxed text-slate-700 sm:text-[0.95rem]">{{ $story->story }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <img
                                        src="{{ asset('storage/'.$story->photo) }}"
                                        alt="{{ $story->name }}"
                                        class="h-16 w-16 shrink-0 rounded-full object-cover ring-2 ring-white sm:h-20 sm:w-20"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                    <div class="rounded-full bg-amber-50 px-1.5 py-0.5 text-[8px] font-bold leading-none tracking-[-0.02em] text-amber-600 shadow-sm ring-1 ring-amber-200/80 sm:text-[9px]">
                                        {{ str_repeat('★', max(1, (int) ($story->rating ?? 5))) }}
                                    </div>
                                </div>
                                <span class="text-xl text-[#43A047]" aria-hidden="true">❝</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="shrink-0 pb-2" :style="`width: ${cardWidth()}px`">
                        <div class="irdc-success-card">
                            <h3 class="text-base font-extrabold text-[#1B5E20] sm:text-lg">No success stories yet</h3>
                            <p class="mt-3 text-sm leading-relaxed text-slate-700">Add active stories from the admin panel to display them here.</p>
                        </div>
                    </article>
                @endforelse
            </div>

            <button
                type="button"
                @click="prev()"
                class="irdc-success-nav irdc-success-nav--left"
                aria-label="Previous success story"
            >‹</button>
            <button
                type="button"
                @click="next()"
                class="irdc-success-nav irdc-success-nav--right"
                aria-label="Next success story"
            >›</button>
        </div>

        <div class="mt-7 flex items-center justify-center gap-2.5">
            <template x-for="dot in pages" :key="'dot-' + dot">
                <button
                    type="button"
                    @click="goTo(dot - 1)"
                    class="h-2.5 rounded-full transition-all duration-300"
                    :class="i === (dot - 1) ? 'w-8 bg-[#43A047]' : 'w-2.5 bg-emerald-900/25 hover:bg-emerald-700/55'"
                    aria-label="Go to success story page"
                ></button>
            </template>
        </div>
    </div>
</section>

{{-- 5. Video: text left, embed right --}}
<section class="irdc-media-section irdc-reveal-on-scroll">
    <div class="container max-w-6xl">
        <div class="irdc-media-shell">
            <div class="irdc-media-copy">
                <p class="irdc-section-kicker">{{ __('messages.home_video_eyebrow') }}</p>
                <h2>{{ __('messages.home_video_title') }}</h2>
                <p>{{ __('messages.home_video_lead') }}</p>
                <ul class="irdc-feature-list">
                    <li>{{ __('messages.home_video_bullet1') }}</li>
                    <li>{{ __('messages.home_video_bullet2') }}</li>
                    <li>{{ __('messages.home_video_bullet3') }}</li>
                </ul>
            </div>
            <div class="irdc-media-visual">
                @if($firstVideo)
                    <div class="irdc-video-frame">
                        <div class="aspect-video w-full overflow-hidden rounded-[1.15rem]">
                            <iframe
                                class="h-full w-full"
                                src="https://www.youtube.com/embed/{{ $firstVideo }}?rel=0"
                                title="YouTube video"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>
                @else
                    <p class="irdc-empty-state">{{ __('messages.home_youtube_empty') }}</p>
                @endif
                <a href="{{ $ytChannel }}" rel="noopener noreferrer" target="_blank" class="irdc-button irdc-button--youtube mt-6">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 7.07 0 9.521 0 12s0 4.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136c.502-.914.502-3.365.502-5.814s0-4.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    {{ __('messages.home_youtube_channel') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- 6. News & updates --}}
@if($homeNews->isNotEmpty())
    <section class="irdc-news-section irdc-reveal-on-scroll">
        <div class="container max-w-6xl">
            <header class="irdc-section-head">
                <p class="irdc-section-head__eyebrow">{{ __('messages.home_news_events') }}</p>
                <h2 class="irdc-section-head__title">{{ __('messages.home_news_title') }}</h2>
                <p class="irdc-section-head__lead">{{ __('messages.home_news_sub') }}</p>
            </header>
            <div class="irdc-news-grid">
                @foreach ($homeNews as $article)
                    <a href="{{ route('news.show', $article) }}" class="irdc-news-card group">
                        <article>
                            @if ($article->image)
                                <div class="irdc-news-card__image">
                                    <img src="{{ asset('storage/'.$article->image) }}" alt="" loading="lazy" decoding="async">
                                </div>
                            @else
                                <div class="irdc-news-card__image irdc-news-card__image--empty">
                                    <span>News</span>
                                </div>
                            @endif
                            <div class="irdc-news-card__body">
                                @if ($article->published_date)
                                    <time datetime="{{ $article->published_date->toDateString() }}">{{ $article->published_date->format('M j, Y') }}</time>
                                @endif
                                <h3>{{ $article->{'title_'.$tLoc} ?? $article->title_en }}</h3>
                                <p>{{ __('messages.read_more') }}</p>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('news.index') }}" class="irdc-button irdc-button--outline">{{ __('messages.home_news_all') }}</a>
            </div>
        </div>
    </section>
@endif

{{-- 7. Gallery preview --}}
<section class="irdc-gallery-section irdc-reveal-on-scroll">
    <div class="container max-w-6xl">
        <header class="irdc-section-head irdc-section-head--emerald">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_gallery_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_gallery_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_gallery_sub') }}</p>
        </header>
        @if($galleryPreview->isNotEmpty())
            <div class="irdc-gallery-grid">
                @foreach($galleryPreview->take(6) as $g)
                    <a href="{{ route('gallery.section', 'photos') }}" class="irdc-gallery-tile group">
                        <img
                            src="{{ $g->mediaUrl() }}"
                            alt="{{ $g->title }}"
                            loading="lazy"
                            decoding="async"
                        >
                        <span>{{ $g->title }}</span>
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('gallery.section', 'photos') }}" class="irdc-button irdc-button--green">{{ __('messages.home_gallery_all') }}</a>
            </div>
        @else
            <p class="irdc-empty-state">{{ __('messages.home_gallery_empty') }}</p>
        @endif
    </div>
</section>

{{-- 8. Vacancies & notices --}}
<section class="irdc-notices-section irdc-reveal-on-scroll">
    <div class="container max-w-5xl">
        <header class="irdc-section-head">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_vacancies_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_vacancies_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_vacancies_sub') }}</p>
        </header>
        @if($vacanciesPreview->isNotEmpty())
            <div class="irdc-notice-list">
                @foreach($vacanciesPreview as $v)
                    <article class="irdc-notice-card">
                        <div>
                            <span>{{ __('messages.home_vacancy_deadline') }}: {{ $v->deadline->format('M j, Y') }}</span>
                            <h3>{{ $v->title }}</h3>
                        </div>
                        <div class="irdc-notice-card__actions">
                            @if(filled($v->pdf_path))
                                <a href="{{ asset('storage/'.$v->pdf_path) }}" rel="noopener" target="_blank" class="irdc-button irdc-button--amber">{{ __('messages.vacancy_download_pdf') }}</a>
                            @endif
                            <a href="{{ route('vacancies.show', $v) }}" class="irdc-button irdc-button--small-outline">{{ __('messages.read_more') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="irdc-empty-state">{{ __('messages.home_vacancies_empty') }}</p>
        @endif
        <div class="mt-10 text-center">
            <a href="{{ route('vacancies.index') }}" class="irdc-button irdc-button--outline">{{ __('messages.home_vacancies_all') }}</a>
        </div>
    </div>
</section>

{{-- 9. Contact (address + map optional) --}}
<section id="contact-block" class="irdc-contact-section irdc-reveal-on-scroll irdc-scroll-mt-header">
    <div class="container max-w-6xl">
        <header class="irdc-section-head">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_contact_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_contact_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_contact_sub') }}</p>
        </header>
        <div class="irdc-contact-grid">
            <div class="irdc-contact-card">
                <span>{{ __('messages.address_label') }}</span>
                <p>{{ config('irdcrp.contact.address') }}</p>
                <span>{{ __('messages.footer_contact') }}</span>
                <a href="tel:{{ preg_replace('/\s+/', '', config('irdcrp.contact.phone')) }}">{{ config('irdcrp.contact.phone') }}</a>
                <a href="mailto:{{ config('irdcrp.contact.email') }}">{{ config('irdcrp.contact.email') }}</a>
                <a href="{{ url('/contact') }}" class="irdc-button irdc-button--outline">{{ __('messages.home_contact_full') }}</a>
            </div>
            <div class="irdc-map-card">
                @if(filled($mapEmbedUrl))
                    <iframe
                        title="{{ __('messages.home_contact_map_title') }}"
                        class="h-full min-h-[18rem] w-full"
                        style="border: 0"
                        src="{{ $mapEmbedUrl }}"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                @else
                    <div>
                        <p>{{ __('messages.home_contact_map_hint') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<a
    href="#top"
    class="fixed bottom-5 right-5 z-40 flex h-11 w-11 items-center justify-center rounded-full border border-emerald-800/20 bg-irdc-green text-white shadow-lg transition hover:bg-emerald-800 sm:bottom-8 sm:right-8"
    title="{{ __('messages.back_to_top') }}"
    aria-label="{{ __('messages.back_to_top') }}"
>
    <span class="text-lg leading-none" aria-hidden="true">↑</span>
</a>
@endsection
