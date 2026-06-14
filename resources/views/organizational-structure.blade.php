@extends('layouts.app')

@section('title', 'Organizational Structure | '.config('app.name', 'IRDCRP'))

@section('content')
<section class="irdc-cms-hero">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <a href="{{ url('/') }}" class="irdc-cms-hero__back">Home</a>
        <p class="irdc-cms-hero__eyebrow">Project Governance</p>
        <h1 class="irdc-cms-hero__title">Organizational Structure</h1>
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/85 sm:text-base">
            Project staff supporting implementation, coordination, and day-to-day delivery across IRDCRP areas.
        </p>
    </div>
</section>

<section class="irdc-leaders-section">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="irdc-leaders-group-head">
            <p class="irdc-leaders-eyebrow">Implementation Team</p>
            <h2 class="irdc-leaders-title">Project Staff</h2>
            <p class="irdc-leaders-subtitle">
                Core PMU and field staff responsible for project operations, monitoring, and stakeholder support.
            </p>
        </header>

        @if ($projectStaff->isNotEmpty())
            <x-leader-grid :leaders="$projectStaff" staff />
        @elseif ($staffFallbackImageUrl)
            <div class="irdc-org-structure-image-card mx-auto mt-10 max-w-5xl">
                <img
                    src="{{ $staffFallbackImageUrl }}"
                    alt="{{ $structure['staff_fallback_image_alt'] ?? 'IRDCRP project staff' }}"
                    class="irdc-org-structure-image-card__img"
                    loading="lazy"
                    decoding="async"
                >
            </div>
        @else
            <div class="mx-auto mt-10 max-w-xl rounded-2xl border border-emerald-100 bg-white p-8 text-center shadow-sm">
                <p class="text-sm text-slate-600">Project staff profiles will appear here once published in the admin panel.</p>
            </div>
        @endif

    </div>
</section>

@if ($structureImageUrl)
    <section class="irdc-org-structure-chart bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="mx-auto mb-8 max-w-3xl text-center">
                <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-emerald-700">Governance chart</p>
                <h2 class="font-display text-3xl font-extrabold tracking-tight text-[#0A3D62] sm:text-4xl">
                    {{ $structure['section_title'] ?? 'Organizational Structure' }}
                </h2>
                @if(filled($structure['section_subtitle'] ?? null))
                    <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">{{ $structure['section_subtitle'] }}</p>
                @endif
            </header>

            <div class="irdc-org-structure-image-card mx-auto max-w-6xl">
                <img
                    src="{{ $structureImageUrl }}"
                    alt="{{ $structure['image_alt'] ?? 'IRDCRP organizational structure' }}"
                    class="irdc-org-structure-image-card__img irdc-org-structure-image-card__img--chart"
                    loading="lazy"
                    decoding="async"
                >
            </div>
        </div>
    </section>
@endif
@endsection
