@extends('layouts.app')

@section('content')
<section class="irdc-vacancies-hero">
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-14">
        <a href="{{ route('vacancies.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-white underline-offset-4 hover:underline">&larr; {{ __('messages.nav_vacancies') }}</a>
        <h1 class="mt-5 break-words font-display text-3xl font-extrabold sm:text-4xl">{{ $vacancy->title }}</h1>
        <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-white">
            <p>Deadline: <strong>{{ $vacancy->deadline->format('F j, Y') }}</strong></p>
            @if($vacancy->status === 'open' && $vacancy->isOpenForPublic())
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-900">Open</span>
            @else
                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-900">Closed / passed</span>
            @endif
        </div>
    </div>
</section>

<section class="bg-slate-50 px-4 py-8 sm:px-6 sm:py-12">
    <div class="mx-auto max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @if(filled($vacancy->description))
            <div class="prose max-w-none break-words text-slate-700">{!! nl2br(e($vacancy->description)) !!}</div>
        @endif
        @if(filled($vacancy->pdf_path))
            <div class="mt-6 border-t border-slate-200 pt-6">
                <a class="irdc-button irdc-vacancy-download" href="{{ route('vacancies.file', $vacancy) }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 3v12m-5-5 5 5 5-5M5 16v4h14v-4" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    Download notice (PDF)
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
