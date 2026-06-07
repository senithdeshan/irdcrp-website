@extends('layouts.app')

@section('title', __('messages.nav_vacancies').' | '.config('app.name'))

@section('content')
@php
    $openCount = $items->filter(fn ($v) => $v->status === 'open' && $v->isOpenForPublic())->count();
    $closedCount = $items->count() - $openCount;
@endphp

<section class="irdc-vacancies-hero">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <a href="{{ url('/') }}" class="irdc-vacancies-hero__back">← Home</a>
        <p class="irdc-vacancies-hero__eyebrow">Project notices</p>
        <h1 class="irdc-vacancies-hero__title">{{ __('messages.nav_vacancies') }}</h1>
        <p class="irdc-vacancies-hero__lead">
            Download application documents, track closing dates, and open full notice details from one place.
        </p>
        <div class="irdc-vacancies-hero__stats">
            <span class="irdc-vacancies-hero__stat irdc-vacancies-hero__stat--open">{{ $openCount }} open</span>
            <span class="irdc-vacancies-hero__stat irdc-vacancies-hero__stat--closed">{{ $closedCount }} closed</span>
            <span class="irdc-vacancies-hero__stat irdc-vacancies-hero__stat--total">{{ $items->count() }} total</span>
        </div>
    </div>
</section>

<section class="irdc-vacancies-board">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <header class="irdc-vacancies-board__head">
            <div>
                <p class="irdc-notices-head__eyebrow">Timeline</p>
                <h2 class="irdc-notices-head__title">All notices & vacancies</h2>
                <p class="irdc-notices-head__lead">
                    Open notices show a live countdown using your system time. Finished notices remain available in red for reference.
                </p>
            </div>
        </header>

        @if($items->isNotEmpty())
            <div class="irdc-notice-list">
                @foreach($items as $v)
                    @php
                        $noticeClosed = $v->status !== 'open' || $v->deadline->copy()->endOfDay()->isPast();
                    @endphp
                    <article class="irdc-notice-card {{ $noticeClosed ? 'irdc-notice-card--closed' : '' }}">
                        <div class="irdc-notice-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M7 3h7l4 4v14H7V3Z"/>
                                <path d="M14 3v5h4"/>
                                <path d="M9.5 13h5"/>
                                <path d="M9.5 17h4"/>
                            </svg>
                        </div>
                        <div class="irdc-notice-card__content">
                            <span>Deadline: {{ $v->deadline->format('M j, Y') }}</span>
                            <h3>{{ $v->title }}</h3>
                            <p class="irdc-vacancies-board__summary">
                                {{ \Illuminate\Support\Str::limit(strip_tags($v->description), 190) }}
                            </p>
                            <a
                                href="{{ route('vacancies.show', $v) }}"
                                class="irdc-notice-countdown"
                                x-data="irdcDeadlineCountdown('{{ $v->deadline->toDateString() }}')"
                                x-init="start()"
                                :class="{ 'irdc-notice-countdown--closed': expired }"
                            >
                                <span class="irdc-notice-countdown__dot" aria-hidden="true"></span>
                                <span x-text="label"></span>
                            </a>
                        </div>
                        <div class="irdc-notice-card__actions">
                            @if(filled($v->pdf_path))
                                <a href="{{ route('vacancies.file', $v) }}" class="irdc-button irdc-button--amber">Download PDF</a>
                            @endif
                            <a href="{{ route('vacancies.show', $v) }}" class="irdc-button irdc-button--small-outline">View details</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="irdc-empty-state">No vacancies published yet.</p>
        @endif
    </div>
</section>

@endsection
