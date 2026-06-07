@extends('layouts.app')

@section('title', __('messages.site_page_title_home'))
@section('meta_description', __('messages.site_meta_description'))

@php
    $homeImages = $homeImages ?? collect();
    $slides = $homeImages->isNotEmpty()
        ? $homeImages->map(fn ($image) => [
            'image' => $image->imageUrl(),
            'caption_en' => $image->caption ?? '',
        ])->values()->all()
        : config('irdcrp.hero_slides', []);
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
    $heroSlideIntervalMs = $heroSlideIntervalMs ?? 10000;
    $programmes = $programmes ?? collect();
    $socialLinks = $socialLinks ?? config('irdcrp.social', []);
    $ytConfig = config('irdcrp.youtube', []);
    $ytChannel = $socialLinks['youtube'] ?? ($ytConfig['channel_url'] ?? 'https://www.youtube.com/');
    $ytIds = $ytConfig['embed_ids'] ?? [];
    $videoCards = collect($ytIds)->filter()->values();
    $homeVideos = $homeVideos ?? collect();
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
    $successStories = $successStories ?? collect();
    $latestInsights = $latestInsights ?? collect();
    $projectPartners = $projectPartners ?? collect();
    $programmeCards = collect(config('irdcrp.programme_cards', []));
    $weatherWidget = $weatherWidget ?? app(\App\Support\SiteSettings::class)->weatherWidget(
        in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en'
    );
@endphp

@section('content')
<div id="top"></div>

<section
    x-data="{
        i: 0,
        n: 1,
        slides: @js($slides),
        slideIntervalMs: @js($heroSlideIntervalMs),
        prev() { this.i = (this.i - 1 + this.n) % this.n; },
        next() { this.i = (this.i + 1) % this.n; },
    }"
    x-init="n = Math.max(slides && slides.length ? slides.length : 0, 1); if (slides && slides.length > 1) { setInterval(() => { i = (i + 1) % n }, slideIntervalMs) }"
    class="irdc-hero relative min-h-[100svh] min-h-screen overflow-hidden text-white"
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

    <div class="relative z-10 box-border flex min-h-[100svh] min-h-screen flex-col pt-8 sm:pt-10">
        <div class="irdc-hero-anim irdc-hero-stagger mx-auto flex w-full max-w-7xl flex-1 flex-col justify-center px-3 pb-44 text-center sm:px-5 sm:pb-48 lg:px-8">
            @if(filled(__('messages.hero_eyebrow')))
                <p class="irdc-hero__eyebrow irdc-hero-stagger__item">{{ __('messages.hero_eyebrow') }}</p>
            @endif
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
                    {{ __('messages.home_hero_learn') }} <span aria-hidden="true">&rarr;</span>
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
                <p class="mt-2 text-xs text-white/50">{{ __('messages.read_more') }} &rarr;</p>
            </a>
        @endif

        <div class="absolute bottom-0 left-0 right-0 z-20 border-t border-white/15 bg-slate-950/55 px-3 py-3.5 backdrop-blur-md sm:px-5 lg:px-8">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
                <div class="flex min-w-0 flex-1 items-center gap-2">
                    <button type="button" @click="prev()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-white/25 text-white transition hover:bg-white/15" aria-label="Previous slide">&lsaquo;</button>
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
                <button type="button" @click="next()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-white/25 text-white transition hover:bg-white/15" aria-label="Next slide">&rsaquo;</button>
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
    <a href="{{ $socialLinks['youtube'] ?? config('irdcrp.social.youtube') }}" target="_blank" rel="noopener noreferrer" title="YouTube" class="irdc-hero-social__btn">
        <x-social-icon name="youtube" class="h-5 w-5" />
    </a>
    <a href="{{ $socialLinks['facebook'] ?? config('irdcrp.social.facebook') }}" target="_blank" rel="noopener noreferrer" title="Facebook" class="irdc-hero-social__btn">
        <x-social-icon name="facebook" class="h-5 w-5" />
    </a>
    <a href="{{ $socialLinks['twitter'] ?? config('irdcrp.social.twitter') }}" target="_blank" rel="noopener noreferrer" title="X" class="irdc-hero-social__btn">
        <x-social-icon name="x" class="h-5 w-5" />
    </a>
    <a href="{{ $socialLinks['linkedin'] ?? config('irdcrp.social.linkedin') }}" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="irdc-hero-social__btn">
        <x-social-icon name="linkedin" class="h-5 w-5" />
    </a>
    <a href="{{ $socialLinks['instagram'] ?? config('irdcrp.social.instagram') }}" target="_blank" rel="noopener noreferrer" title="Instagram" class="irdc-hero-social__btn">
        <x-social-icon name="instagram" class="h-5 w-5" />
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

@php
    $homeBlocks = $homeBlocks ?? app(\App\Support\SiteSettings::class)->homeBlocksForPublic();
@endphp

@foreach ($homeBlocks as $homeBlock)
    @include('home.blocks.'.\App\Support\HomePageBlocks::viewName($homeBlock['id']))
@endforeach

<a
    href="#top"
    class="fixed bottom-5 right-5 z-40 flex h-11 w-11 items-center justify-center rounded-full border border-emerald-800/20 bg-irdc-green text-white shadow-lg transition hover:bg-emerald-800 sm:bottom-8 sm:right-8"
    title="{{ __('messages.back_to_top') }}"
    aria-label="{{ __('messages.back_to_top') }}"
>
    <span class="text-lg leading-none" aria-hidden="true">↑</span>
</a>
@endsection
