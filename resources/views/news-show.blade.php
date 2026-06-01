@extends('layouts.app')

@section('title', $news->title_en.' | '.config('app.name'))

@section('content')
@php
    $tLoc = in_array(app()->getLocale(), ['en', 'si', 'ta'], true) ? app()->getLocale() : 'en';
    $title = $news->{'title_'.$tLoc} ?? $news->title_en;
    $content = $news->{'content_'.$tLoc} ?? $news->content_en;
    $imageUrls = $news->imageUrls();
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
        <article
            class="irdc-news-show-card"
            x-data="{
                images: @js($imageUrls),
                active: 0,
                open: false,
                show(index) {
                    this.active = index;
                    this.open = true;
                },
                close() {
                    this.open = false;
                },
                next() {
                    this.active = (this.active + 1) % this.images.length;
                },
                previous() {
                    this.active = (this.active - 1 + this.images.length) % this.images.length;
                },
            }"
            x-on:keydown.window.escape="close()"
            x-on:keydown.window.arrow-right="open && next()"
            x-on:keydown.window.arrow-left="open && previous()"
        >
            @if(count($imageUrls) > 0)
                <button type="button" class="irdc-news-show-card__image-button" x-on:click="show(0)" aria-label="Open cover image">
                    <img src="{{ $imageUrls[0] }}" alt="{{ $title }}" class="irdc-news-show-card__image">
                </button>
            @endif

            <div class="irdc-news-show-card__content">
                {!! nl2br(e($content)) !!}
            </div>

            @if(count($imageUrls) > 1)
                <div class="irdc-news-show-more-images">
                    @foreach(array_slice($imageUrls, 1) as $imageUrl)
                        <button type="button" class="irdc-news-show-more-images__item" x-on:click="show({{ $loop->iteration }})" aria-label="Open image {{ $loop->iteration + 1 }}">
                            <img src="{{ $imageUrl }}" alt="{{ $title }}" loading="lazy" decoding="async">
                        </button>
                    @endforeach
                </div>
            @endif

            @if(count($imageUrls) > 0)
                <div
                    x-show="open"
                    x-cloak
                    x-transition.opacity
                    class="irdc-news-lightbox"
                    role="dialog"
                    aria-modal="true"
                    aria-label="News image viewer"
                >
                    <button type="button" class="irdc-news-lightbox__backdrop" x-on:click="close()" aria-label="Close image viewer"></button>
                    <div class="irdc-news-lightbox__panel">
                        <div class="irdc-news-lightbox__top">
                            <span x-text="(active + 1) + ' / ' + images.length"></span>
                            <button type="button" x-on:click="close()" aria-label="Close image viewer">Close</button>
                        </div>

                        <div class="irdc-news-lightbox__stage">
                            <button type="button" class="irdc-news-lightbox__nav" x-on:click="previous()" aria-label="Previous image" x-show="images.length > 1">&lsaquo;</button>
                            <img :src="images[active]" alt="{{ $title }}">
                            <button type="button" class="irdc-news-lightbox__nav" x-on:click="next()" aria-label="Next image" x-show="images.length > 1">&rsaquo;</button>
                        </div>

                        <div class="irdc-news-lightbox__thumbs" x-show="images.length > 1">
                            <template x-for="(image, index) in images" :key="image">
                                <button type="button" x-on:click="active = index" :class="{ 'is-active': active === index }" aria-label="View image">
                                    <img :src="image" alt="">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            @endif

            <a href="{{ route('news.index') }}" class="irdc-button irdc-button--outline mt-8">Back to News</a>
        </article>
    </div>
</section>

@endsection
