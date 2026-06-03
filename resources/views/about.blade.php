@extends('layouts.app')

@section('content')

<section class="irdc-about-modern relative isolate overflow-hidden py-16 sm:py-20">
    <div class="irdc-about-modern__bg absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-about-modern__overlay absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-about-modern__wave-top" aria-hidden="true"></div>
    <div class="irdc-about-modern__wave-bottom" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <header class="text-center">
            <h1 class="irdc-about-modern__title">{{ $about['hero_title'] }}</h1>
            <p class="irdc-about-modern__subtitle">{{ $about['hero_subtitle'] }}</p>
        </header>

        <div class="mt-10 grid gap-4 sm:gap-5 md:grid-cols-2">
            <article class="irdc-about-glass-card">
                <h2 class="irdc-about-glass-card__title">{{ $about['mission_title'] }}</h2>
                <p class="irdc-about-glass-card__text">{{ $about['mission_text'] }}</p>
            </article>
            <article class="irdc-about-glass-card">
                <h2 class="irdc-about-glass-card__title">{{ $about['objectives_title'] }}</h2>
                <p class="irdc-about-glass-card__text">{{ $about['objectives_text'] }}</p>
            </article>
        </div>

        <section class="irdc-about-panel mt-7 sm:mt-8">
            <h2 class="irdc-about-panel__heading">{{ $about['grievance_heading'] }}</h2>
            <p class="irdc-about-panel__lead">{{ $about['grievance_lead'] }}</p>
            <div class="mt-5 grid gap-4 sm:grid-cols-3">
                @foreach ($about['grievance_cards'] as $card)
                    <article class="irdc-about-mini-card">
                        <h3>{{ $card['title'] }}</h3>
                        <p>{{ $card['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="irdc-about-panel mt-7 sm:mt-8">
            <h2 class="irdc-about-panel__heading">{{ $about['why_heading'] }}</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-3">
                @foreach ($about['why_cards'] as $card)
                    <article class="irdc-about-mini-card">
                        <h3>{{ $card['title'] }}</h3>
                        <p>{{ $card['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
</section>

@endsection
