@extends('layouts.app')

@section('content')
<section class="irdc-programme-show">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-14 sm:px-6 sm:py-16 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:px-8">
        <div>
            <a href="{{ route('programmes.index') }}" class="irdc-programme-show__back">Back to programmes</a>
            @if($programme->componentLabel())
                <p class="irdc-programme-show__component">{{ $programme->componentLabel() }}</p>
            @endif
            <h1 class="irdc-programme-show__title">{{ $programme->title }}</h1>
            @if($programme->summary)
                <p class="irdc-programme-show__lead">{{ $programme->summary }}</p>
            @endif
        </div>
        <div
            class="irdc-programme-show__image"
            x-data="{ open: false }"
            x-on:keydown.window.escape="open = false"
        >
            <button
                type="button"
                class="irdc-programme-show__image-button"
                x-on:click="open = true"
                aria-label="Open programme cover image"
            >
                <img src="{{ $programme->coverImageUrl() }}" alt="{{ $programme->title }}">
            </button>

            <template x-teleport="body">
                <div
                    x-show="open"
                    x-cloak
                    x-transition.opacity
                    class="irdc-news-lightbox irdc-programme-lightbox"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Programme cover image viewer"
                >
                    <button type="button" class="irdc-news-lightbox__backdrop" x-on:click="open = false" aria-label="Close image viewer"></button>
                    <div class="irdc-news-lightbox__panel">
                        <div class="irdc-news-lightbox__top">
                            <span>{{ $programme->title }}</span>
                            <button type="button" x-on:click="open = false" aria-label="Close image viewer">Close</button>
                        </div>

                        <div class="irdc-news-lightbox__stage">
                            <span class="irdc-news-lightbox__nav" style="visibility: hidden;" aria-hidden="true"></span>
                            <img src="{{ $programme->coverImageUrl() }}" alt="{{ $programme->title }}">
                            <span class="irdc-news-lightbox__nav" style="visibility: hidden;" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-14 lg:px-8">
        @if(filled($programme->description))
            <div class="irdc-programme-show__intro">
                {!! nl2br(e($programme->description)) !!}
            </div>
        @endif

        <x-programme-content-blocks :programme="$programme" />
    </div>
</section>

@if($moreProgrammes->isNotEmpty())
    <section class="border-t border-slate-200 bg-slate-50 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-extrabold text-[#0A3D62]">More programmes</h2>
            <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach($moreProgrammes as $item)
                    <a href="{{ route('programmes.show', $item) }}" class="irdc-programme-mini">
                        <img src="{{ $item->coverImageUrl() }}" alt="{{ $item->title }}">
                        <span>{{ $item->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
