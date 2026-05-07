@extends('layouts.app')

@section('content')

<section class="irdc-components-hero">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <div class="max-w-3xl">
            <p class="irdc-components-eyebrow">Implementation Framework</p>
            <h1 class="irdc-components-title">Project Components</h1>
            <p class="irdc-components-lead">
                Five coordinated investment areas guide IRDCRP support for climate-smart production, resilient natural resources, sector services, project learning, and emergency response readiness.
            </p>
        </div>
    </div>
</section>

<section class="irdc-components-section">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-16 lg:px-8">
        <div class="irdc-components-summary">
            <div>
                <p class="irdc-components-summary__label">Core Components</p>
                <h2 class="irdc-components-summary__title">From production support to emergency readiness</h2>
            </div>
            <p class="irdc-components-summary__copy">
                Each component connects field-level benefits with stronger systems, inclusive participation, and improved climate resilience.
            </p>
        </div>

        <div class="irdc-components-grid">
            @forelse($components as $component)
                <article class="irdc-component-card">
                    <div class="irdc-component-card__number">
                        {{ str_pad((string) $component->component_number, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="irdc-component-card__body">
                        <p class="irdc-component-card__kicker">Component {{ $component->component_number }}</p>
                        <h3 class="irdc-component-card__title">{{ $component->title }}</h3>
                        @if($component->budget)
                            <p class="irdc-component-card__budget">{{ $component->budget }}</p>
                        @endif
                        @if($component->beneficiaries)
                            <p class="irdc-component-card__beneficiaries">{{ $component->beneficiaries }}</p>
                        @endif
                        <p class="irdc-component-card__description">{{ $component->description }}</p>
                    </div>
                </article>
            @empty
                <div class="irdc-components-empty">
                    Project components are being updated.
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
