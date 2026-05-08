@extends('layouts.app')

@section('title', $page->title.' | '.config('app.name', 'IRDCRP'))

@section('content')
<section class="irdc-cms-hero">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <a href="{{ url('/') }}" class="irdc-cms-hero__back">Home</a>
        <p class="irdc-cms-hero__eyebrow">IRDCRP information</p>
        <h1 class="irdc-cms-hero__title">{{ $page->title }}</h1>
        <div class="irdc-cms-hero__meta">
            <span>Published page</span>
            @if($page->updated_at)
                <span>Updated {{ $page->updated_at->format('M d, Y') }}</span>
            @endif
        </div>
    </div>
</section>

<section class="irdc-cms-page">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-14 sm:px-6 sm:py-16 lg:grid-cols-[minmax(0,1fr)_19rem] lg:px-8">
        <article class="irdc-cms-card">
            <div class="irdc-cms-content">
                {!! $page->content !!}
            </div>
        </article>

        <aside class="irdc-cms-aside" aria-label="Page actions">
            <div class="irdc-cms-aside__card">
                <p class="irdc-cms-aside__label">Continue to</p>
                <a href="{{ url('/') }}" class="irdc-cms-aside__link">Home</a>
                <a href="{{ route('programmes.index') }}" class="irdc-cms-aside__link">Programmes</a>
                <a href="/news" class="irdc-cms-aside__link">News & Events</a>
                <a href="/contact" class="irdc-cms-aside__link">Contact</a>
            </div>
        </aside>
    </div>
</section>
@endsection
