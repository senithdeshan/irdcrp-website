@extends('layouts.app')

@section('title', 'News & Events | '.config('app.name'))

@section('content')
@php
    $tLoc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
@endphp

<section class="irdc-news-page-hero">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <a href="{{ url('/') }}" class="irdc-news-page-hero__back">← Home</a>
        <p class="irdc-news-page-hero__eyebrow">Latest updates</p>
        <h1 class="irdc-news-page-hero__title">News & Events</h1>
        <p class="irdc-news-page-hero__lead">
            Official announcements, procurement notices, and field stories from IRDCRP.
        </p>
        <div class="irdc-news-page-hero__stats">
            <span>{{ $news->count() }} published updates</span>
        </div>
    </div>
</section>

<section class="irdc-news-page-list">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <header class="irdc-news-head">
            <div>
                <p class="irdc-news-head__eyebrow">News archive</p>
                <h2 class="irdc-news-head__title">All updates</h2>
                <p class="irdc-news-head__lead">
                    Follow project milestones, community activities, announcements, and implementation progress.
                </p>
            </div>
        </header>

        @if($news->isNotEmpty())
            <div class="irdc-news-grid">
                @foreach($news as $item)
                    <a href="{{ route('news.show', $item) }}" class="irdc-news-card group">
                        <article>
                            @if($item->imageUrl())
                                <div class="irdc-news-card__image">
                                    <img src="{{ $item->imageUrl() }}" alt="{{ $item->{'title_'.$tLoc} ?? $item->title_en }}" loading="lazy" decoding="async">
                                </div>
                            @else
                                <div class="irdc-news-card__image irdc-news-card__image--empty">
                                    <span>News</span>
                                </div>
                            @endif

                            <div class="irdc-news-card__body">
                                <div class="irdc-news-card__meta">
                                    @if($item->published_date)
                                        <time datetime="{{ $item->published_date->toDateString() }}">{{ $item->published_date->format('M j, Y') }}</time>
                                    @else
                                        <time>No date</time>
                                    @endif
                                    @if($item->is_pinned)
                                        <span class="irdc-news-card__pin">Pinned</span>
                                    @endif
                                </div>
                                <h3>{{ $item->{'title_'.$tLoc} ?? $item->title_en }}</h3>
                                <div class="irdc-news-card__summary">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->{'content_'.$tLoc} ?? $item->content_en), 120) }}
                                </div>
                                <p><span>{{ __('messages.read_more') }}</span></p>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        @else
            <div class="irdc-empty-state">
                <h2 class="font-display text-xl font-extrabold text-slate-900">No news available yet.</h2>
                <p class="mt-2 text-sm text-slate-500">Published updates will appear here.</p>
            </div>
        @endif
    </div>
</section>

@endsection
