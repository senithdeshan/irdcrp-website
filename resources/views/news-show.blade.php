@extends('layouts.app')

@section('title', $news->title_en.' | '.config('app.name'))

@section('content')
@php
    $tLoc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
    $title = $news->{'title_'.$tLoc} ?? $news->title_en;
    $content = $news->{'content_'.$tLoc} ?? $news->content_en;
@endphp

<section class="irdc-news-show-hero">
    <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 sm:py-18 lg:px-8">
        <a href="{{ route('news.index') }}" class="irdc-news-page-hero__back">← News & Events</a>
        <p class="irdc-news-page-hero__eyebrow">Project update</p>
        <h1 class="irdc-news-show-hero__title">{{ $title }}</h1>
        @if($news->published_date)
            <p class="irdc-news-show-hero__date">{{ $news->published_date->format('F j, Y') }}</p>
        @endif
    </div>
</section>

<section class="irdc-news-show-page">
    <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 sm:py-16 lg:px-8">
        <article class="irdc-news-show-card">
            @if($news->image)
                <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $title }}" class="irdc-news-show-card__image">
            @endif

            <div class="irdc-news-show-card__content">
                {!! nl2br(e($content)) !!}
            </div>

            <a href="{{ route('news.index') }}" class="irdc-button irdc-button--outline mt-8">Back to News</a>
        </article>
    </div>
</section>

@endsection
