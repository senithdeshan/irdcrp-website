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
    $programmeCards = config('irdcrp.programme_cards', []);
    $ytConfig = config('irdcrp.youtube', []);
    $ytChannel = $ytConfig['channel_url'] ?? 'https://www.youtube.com/';
    $ytIds = $ytConfig['embed_ids'] ?? [];
    $firstVideo = $ytIds[0] ?? null;
    $tLoc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
    $stats = config('irdcrp.home_stats', []);
    $mapEmbedUrl = config('irdcrp.map_embed_url');
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
                class="absolute inset-0 min-h-full bg-center bg-cover"
                :style="`background-image: url('${s.image}')`"
            ></div>
        </template>
        @if(count($slides) === 0)
            <div
                class="absolute inset-0 min-h-full bg-center bg-cover"
                style="background-image: url('https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1920&q=80');"
            ></div>
        @endif
        <div class="irdc-hero__veil absolute inset-0 min-h-full" aria-hidden="true"></div>
    </div>

    <div class="relative z-10 flex min-h-[100svh] min-h-screen flex-col">
        <div class="irdc-hero-anim mx-auto flex w-full max-w-7xl flex-1 flex-col justify-center px-3 pb-44 pt-[var(--irdc-header-offset)] text-center sm:px-5 sm:pb-48 lg:px-8">
            <p class="irdc-hero__eyebrow">{{ __('messages.hero_eyebrow') }}</p>
            <h1 class="irdc-hero__title mt-6 sm:mt-7">
                {{ $heroTitle }}
            </h1>
            <p
                x-show="slides && slides.length"
                x-text="slides && slides[i] && (slides[i].caption_en || '')"
                x-cloak
                class="irdc-hero__lead"
            ></p>
            <p
                x-show="! slides || slides.length === 0"
                x-cloak
                class="irdc-hero__lead"
            >{{ e($firstCaption) ?: __('messages.hero_caption') }}</p>
            <div class="irdc-hero__actions">
                <a href="/about" class="irdc-hero__btn-primary">
                    {{ __('messages.home_hero_learn') }} <span aria-hidden="true">→</span>
                </a>
                <a href="{{ url('/#programmes') }}" class="irdc-hero__btn-secondary">
                    {{ __('messages.home_hero_view_programmes') }}
                </a>
            </div>
            <a href="#about-project" class="irdc-hero__scroll">
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

{{-- Institutional context — clear for stakeholders & presentations --}}
<div class="border-b border-t border-emerald-950/15 bg-gradient-to-r from-emerald-50 via-white to-cyan-50/80 py-3.5 text-center shadow-sm">
    <p class="mx-auto max-w-7xl px-3 text-xs font-medium leading-relaxed text-slate-700 sm:px-5 sm:text-sm lg:px-8">
        <span class="font-display font-bold text-[#0A3D62]">{{ __('messages.home_trust_gosl') }}</span>
        <span class="mx-1.5 text-slate-300 sm:mx-2" aria-hidden="true">·</span>
        <span>{{ __('messages.home_trust_partners') }}</span>
    </p>
</div>

{{-- 2. Project identity: Sinhala / Tamil / English + short lead --}}
<section id="about-project" class="irdc-reveal-on-scroll irdc-scroll-mt-header border-b border-stone-200/80 bg-white py-20 sm:py-28">
    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6">
        <header class="irdc-section-head !mb-8 sm:!mb-10">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_trilingual_eyebrow') }}</p>
        </header>
        <div class="space-y-3 sm:space-y-4">
            @foreach ($titleLines as $line)
                <p
                    @class([
                        'font-display text-2xl font-extrabold leading-snug text-irdc-burgundy sm:text-3xl md:text-4xl' => $loop->last,
                        'text-lg font-medium leading-relaxed text-slate-800 sm:text-xl md:text-2xl' => ! $loop->last,
                    ])
                >{{ $line }}</p>
            @endforeach
        </div>
        <p class="mx-auto mt-10 max-w-3xl text-base leading-relaxed text-slate-600 sm:mt-12 sm:text-lg md:text-xl">
            {{ __('messages.home_identity_lead') }}
        </p>
    </div>
</section>

{{-- 3. Impact / statistics --}}
<section class="irdc-reveal-on-scroll border-b border-stone-200/80 bg-slate-50/95 py-20 sm:py-24">
    <div class="container max-w-6xl">
        <header class="irdc-section-head irdc-section-head--emerald">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_stats_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_stats_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_stats_sub') }}</p>
        </header>
        <div class="mt-10 grid grid-cols-2 gap-4 sm:mt-12 lg:grid-cols-4 lg:gap-6">
            <article class="irdc-stat-tile">
                <p class="font-display text-4xl font-extrabold tabular-nums text-[#0A3D62] sm:text-5xl md:text-6xl lg:text-6xl">{{ $stats['districts'] ?? '00' }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_districts') }}</p>
            </article>
            <article class="irdc-stat-tile">
                <p class="font-display text-4xl font-extrabold tabular-nums text-emerald-800 sm:text-5xl md:text-6xl lg:text-6xl">{{ $stats['beneficiaries'] ?? '00' }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_beneficiaries') }}</p>
            </article>
            <article class="irdc-stat-tile">
                <p class="font-display text-4xl font-extrabold tabular-nums text-[#0A3D62] sm:text-5xl md:text-6xl lg:text-6xl">{{ $stats['farmers'] ?? '00' }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_farmers') }}</p>
            </article>
            <article class="irdc-stat-tile">
                <p class="font-display text-3xl font-extrabold tabular-nums text-emerald-800 sm:text-4xl md:text-5xl lg:text-6xl">{{ $stats['duration'] ?? '—' }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_duration') }}</p>
            </article>
        </div>
    </div>
</section>

{{-- 4. Programmes --}}
<section id="programmes" class="irdc-reveal-on-scroll irdc-scroll-mt-header border-b border-stone-200/80 bg-white py-20 sm:py-28">
    <div class="container max-w-6xl">
        <header class="irdc-section-head irdc-section-head--emerald">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_programmes_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_programmes_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_programmes_sub') }}</p>
        </header>
        <div class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3 lg:mt-16">
            @foreach($programmeCards as $card)
                <a
                    href="{{ url('/components') }}"
                    class="irdc-home-card group flex flex-col"
                >
                    <div class="relative aspect-[4/3] w-full overflow-hidden rounded-t-3xl bg-slate-200">
                        <img
                            src="{{ $card['image'] ?? '' }}"
                            alt=""
                            class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-110"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                    <div class="flex flex-1 flex-col px-4 py-4 sm:px-5 sm:py-5">
                        <h3 class="text-center font-display text-base font-bold text-slate-900 sm:text-lg">
                            {{ __('messages.prog_'.$card['id']) }}
                        </h3>
                        <p class="mt-2 text-center text-sm leading-relaxed text-slate-600 line-clamp-3 sm:line-clamp-4">
                            {{ __('messages.prog_'.$card['id'].'_desc') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- 5. Video: text left, embed right --}}
<section class="irdc-reveal-on-scroll border-b border-stone-200/80 bg-slate-50/95 py-20 sm:py-28">
    <div class="container max-w-6xl">
        <div class="grid items-start gap-10 lg:grid-cols-2 lg:gap-14">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#0A3D62]/80">{{ __('messages.home_video_eyebrow') }}</p>
                <h2 class="mt-2 font-display text-3xl font-extrabold tracking-tight text-irdc-burgundy sm:text-4xl">{{ __('messages.home_video_title') }}</h2>
                <p class="mt-4 text-lg leading-relaxed text-slate-600 sm:text-xl">{{ __('messages.home_video_lead') }}</p>
                <ul class="mt-6 list-none space-y-3 text-slate-600">
                    <li class="flex gap-2.5 sm:items-start">
                        <span class="mt-0.5 inline-flex h-2 w-2 shrink-0 rounded-full bg-emerald-600" aria-hidden="true"></span>
                        <span>{{ __('messages.home_video_bullet1') }}</span>
                    </li>
                    <li class="flex gap-2.5 sm:items-start">
                        <span class="mt-0.5 inline-flex h-2 w-2 shrink-0 rounded-full bg-[#0A3D62]" aria-hidden="true"></span>
                        <span>{{ __('messages.home_video_bullet2') }}</span>
                    </li>
                    <li class="flex gap-2.5 sm:items-start">
                        <span class="mt-0.5 inline-flex h-2 w-2 shrink-0 rounded-full bg-emerald-600" aria-hidden="true"></span>
                        <span>{{ __('messages.home_video_bullet3') }}</span>
                    </li>
                </ul>
            </div>
            <div class="w-full">
                @if($firstVideo)
                    <div class="overflow-hidden rounded-3xl border border-slate-200/90 bg-slate-900 shadow-2xl ring-1 ring-slate-900/10">
                        <div class="aspect-video w-full">
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
                    <p class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">{{ __('messages.home_youtube_empty') }}</p>
                @endif
                <div class="mt-6 text-center sm:text-left">
                    <a
                        href="{{ $ytChannel }}"
                        rel="noopener noreferrer"
                        target="_blank"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-red-600 px-7 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-red-700 sm:px-8 sm:py-4 sm:text-base"
                    >
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 7.07 0 9.521 0 12s0 4.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136c.502-.914.502-3.365.502-5.814s0-4.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        {{ __('messages.home_youtube_channel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 6. News & updates --}}
@if($homeNews->isNotEmpty())
    <section class="irdc-reveal-on-scroll border-b border-stone-200/80 bg-white py-20 sm:py-28">
        <div class="container max-w-6xl">
            <header class="irdc-section-head">
                <p class="irdc-section-head__eyebrow">{{ __('messages.home_news_events') }}</p>
                <h2 class="irdc-section-head__title">{{ __('messages.home_news_title') }}</h2>
                <p class="irdc-section-head__lead">{{ __('messages.home_news_sub') }}</p>
            </header>
            <div class="row g-4 g-lg-4">
                @foreach($homeNews as $article)
                    @php
                        $nt = $article->{'title_'.$tLoc} ?? $article->title_en;
                    @endphp
                    <div class="col-12 col-md-4">
                        <a href="{{ route('news.show', $article) }}" class="group block h-full">
                            <article class="irdc-home-card flex h-full flex-col bg-slate-50/50">
                                @if($article->image)
                                    <div class="aspect-[16/10] w-full overflow-hidden rounded-t-3xl bg-slate-200">
                                        <img src="{{ asset('storage/'.$article->image) }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    </div>
                                @else
                                    <div class="flex aspect-[16/10] w-full items-center justify-center rounded-t-3xl bg-gradient-to-br from-[#0A3D62]/8 to-emerald-600/10 text-4xl text-[#0A3D62]/30">📰</div>
                                @endif
                                <div class="flex flex-1 flex-col p-5 sm:p-6">
                                    <h3 class="font-display text-lg font-bold text-slate-900 line-clamp-2 group-hover:text-[#0A3D62] sm:text-xl">{{ $nt }}</h3>
                                    @if($article->published_date)
                                        <p class="mt-2 text-sm text-slate-500">{{ $article->published_date->format('M j, Y') }}</p>
                                    @endif
                                    <p class="mt-3 text-sm font-semibold text-emerald-800">{{ __('messages.read_more') }} →</p>
                                </div>
                            </article>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('news.index') }}" class="inline-flex items-center justify-center rounded-full border-2 border-[#0A3D62] bg-transparent px-8 py-3.5 text-sm font-bold text-[#0A3D62] transition hover:bg-[#0A3D62] hover:text-white sm:px-10 sm:py-4 sm:text-base">{{ __('messages.home_news_all') }}</a>
            </div>
        </div>
    </section>
@endif

{{-- 7. Gallery preview --}}
<section class="irdc-reveal-on-scroll border-b border-stone-200/80 bg-slate-50/95 py-20 sm:py-28">
    <div class="container max-w-6xl">
        <header class="irdc-section-head irdc-section-head--emerald">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_gallery_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_gallery_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_gallery_sub') }}</p>
        </header>
        @if($galleryPreview->isNotEmpty())
            <div class="grid grid-cols-2 gap-2.5 sm:grid-cols-3 sm:gap-3">
                @foreach($galleryPreview->take(6) as $g)
                    <a href="{{ route('gallery.index') }}" class="group relative block aspect-[4/3] overflow-hidden rounded-xl border border-slate-200/90 bg-slate-200 shadow-sm sm:rounded-2xl">
                        <img
                            src="{{ asset('storage/'.$g->image) }}"
                            alt="{{ $g->title }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                            loading="lazy"
                            decoding="async"
                        >
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center justify-center rounded-full border-2 border-emerald-800 bg-white px-8 py-3.5 text-sm font-bold text-emerald-900 shadow-sm transition hover:bg-emerald-800 hover:text-white sm:px-10 sm:py-4 sm:text-base">{{ __('messages.home_gallery_all') }}</a>
            </div>
        @else
            <p class="text-center text-slate-500">{{ __('messages.home_gallery_empty') }}</p>
        @endif
    </div>
</section>

{{-- 8. Vacancies & notices --}}
<section class="irdc-reveal-on-scroll border-b border-stone-200/80 bg-white py-20 sm:py-28">
    <div class="container max-w-5xl">
        <header class="irdc-section-head">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_vacancies_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_vacancies_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_vacancies_sub') }}</p>
        </header>
        @if($vacanciesPreview->isNotEmpty())
            <div class="mx-auto space-y-4">
                @foreach($vacanciesPreview as $v)
                    <div class="group relative overflow-hidden rounded-2xl border border-orange-200/80 bg-gradient-to-r from-amber-50/90 via-white to-white shadow-sm ring-1 ring-orange-200/30 transition hover:shadow-md">
                        <div class="absolute left-0 top-0 h-full w-1.5 bg-gradient-to-b from-amber-500 to-orange-600" aria-hidden="true"></div>
                        <div class="flex flex-col gap-4 p-4 pl-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5">
                            <div class="min-w-0 pr-2">
                                <h3 class="font-display text-lg font-bold text-slate-900 sm:text-xl">{{ $v->title }}</h3>
                                <p class="mt-1.5 text-sm text-orange-900/80">
                                    <span class="font-semibold">{{ __('messages.home_vacancy_deadline') }}:</span> {{ $v->deadline->format('M j, Y') }}
                                </p>
                            </div>
                            <div class="flex shrink-0 flex-wrap items-center gap-2">
                                @if(filled($v->pdf_path))
                                    <a
                                        href="{{ asset('storage/'.$v->pdf_path) }}"
                                        rel="noopener"
                                        target="_blank"
                                        class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-amber-600 to-orange-600 px-5 py-2.5 text-sm font-bold text-white shadow transition hover:from-amber-700 hover:to-orange-700"
                                    >{{ __('messages.vacancy_download_pdf') }}</a>
                                @endif
                                <a
                                    href="{{ route('vacancies.show', $v) }}"
                                    class="inline-flex items-center justify-center rounded-full border-2 border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-800 transition hover:border-[#0A3D62] hover:text-[#0A3D62]"
                                >{{ __('messages.read_more') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-slate-500">{{ __('messages.home_vacancies_empty') }}</p>
        @endif
        <div class="mt-10 text-center">
            <a href="{{ route('vacancies.index') }}" class="inline-flex items-center justify-center rounded-full border-2 border-[#0A3D62] bg-transparent px-8 py-3.5 text-sm font-bold text-[#0A3D62] transition hover:bg-[#0A3D62] hover:text-white sm:px-10 sm:py-4 sm:text-base">{{ __('messages.home_vacancies_all') }}</a>
        </div>
    </div>
</section>

{{-- 9. Contact (address + map optional) --}}
<section id="contact-block" class="irdc-reveal-on-scroll irdc-scroll-mt-header border-b border-stone-200/80 bg-slate-100/90 py-20 sm:py-28">
    <div class="container max-w-6xl">
        <header class="irdc-section-head !mb-10 sm:!mb-12">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_contact_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_contact_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_contact_sub') }}</p>
        </header>
        <div class="mt-8 grid gap-8 lg:grid-cols-2 lg:items-stretch">
            <div class="flex flex-col justify-center rounded-3xl border border-slate-200/90 bg-white p-6 shadow-md shadow-slate-900/5 ring-1 ring-slate-900/[0.03] sm:p-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('messages.address_label') }}</p>
                <p class="mt-2 text-lg font-medium text-slate-800">{{ config('irdcrp.contact.address') }}</p>
                <p class="mt-5 text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('messages.footer_contact') }}</p>
                <a class="mt-1 text-lg font-semibold text-[#0A3D62] hover:underline" href="tel:{{ preg_replace('/\s+/', '', config('irdcrp.contact.phone')) }}">{{ config('irdcrp.contact.phone') }}</a>
                <a class="mt-1 break-words text-lg font-semibold text-[#0A3D62] hover:underline" href="mailto:{{ config('irdcrp.contact.email') }}">{{ config('irdcrp.contact.email') }}</a>
                <a href="{{ url('/contact') }}" class="mt-6 inline-flex w-fit items-center gap-2 rounded-full border-2 border-[#0A3D62] bg-transparent px-5 py-2.5 text-sm font-bold text-[#0A3D62] transition hover:bg-[#0A3D62] hover:text-white sm:px-6 sm:py-3">
                    {{ __('messages.home_contact_full') }} →
                </a>
            </div>
            <div class="min-h-[16rem] overflow-hidden rounded-3xl border border-slate-200/90 bg-slate-200 shadow-inner">
                @if(filled($mapEmbedUrl))
                    <iframe
                        title="{{ __('messages.home_contact_map_title') }}"
                        class="h-full min-h-[16rem] w-full"
                        style="min-height: 20rem; border: 0"
                        src="{{ $mapEmbedUrl }}"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                @else
                    <div class="flex h-full min-h-[16rem] flex-col items-center justify-center bg-slate-100/90 p-6 text-center sm:min-h-[20rem]">
                        <p class="text-slate-500 sm:text-base">{{ __('messages.home_contact_map_hint') }}</p>
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
