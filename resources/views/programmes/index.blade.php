@extends('layouts.app')

@section('content')
<section class="irdc-programmes-hero">
    <div class="mx-auto max-w-7xl px-4 pb-3 pt-8 text-center sm:px-6 sm:pb-4 sm:pt-10 lg:px-8 lg:pt-11">
        <p class="irdc-programmes-eyebrow">Field Implementation</p>
        <h1 class="irdc-programmes-title">Programmes</h1>
        <p class="irdc-programmes-lead">Climate-smart programmes supporting production, training, home gardens, seeds, monitoring, and market linkages.</p>
    </div>
</section>

<section class="irdc-programmes-section">
    <div class="mx-auto max-w-7xl px-4 pb-14 pt-1 sm:px-6 sm:pb-16 sm:pt-2 lg:px-8 lg:pt-3">
        @if($components->isNotEmpty())
            <div class="irdc-programmes-filter" role="tablist" aria-label="Filter programmes by project component">
                <a
                    href="{{ route('programmes.index') }}"
                    class="irdc-programmes-filter__btn {{ $selectedComponent ? '' : 'irdc-programmes-filter__btn--active' }}"
                    @unless($selectedComponent) aria-current="true" @endunless
                >
                    All programmes
                </a>
                @foreach($components as $component)
                    <a
                        href="{{ route('programmes.index', ['component' => $component->component_number]) }}"
                        class="irdc-programmes-filter__btn {{ ($selectedComponent?->id === $component->id) ? 'irdc-programmes-filter__btn--active' : '' }}"
                        title="{{ $component->title }}"
                        @if($selectedComponent?->id === $component->id) aria-current="true" @endif
                    >
                        Component {{ $component->component_number }}
                    </a>
                @endforeach
            </div>

            @if($selectedComponent)
                <p class="irdc-programmes-filter__summary">
                    Showing programmes under <strong>Component {{ $selectedComponent->component_number }}</strong>:
                    {{ $selectedComponent->title }}
                </p>
            @endif
        @endif

        <div class="irdc-programmes-grid">
            @forelse($programmes as $programme)
                <a href="{{ route('programmes.show', $programme) }}" class="irdc-programme-card group">
                    <div class="irdc-programme-card__image">
                        <img src="{{ $programme->coverImageUrl() }}" alt="{{ $programme->title }}" loading="lazy" decoding="async">
                    </div>
                    <div class="irdc-programme-card__body">
                        @if($programme->componentLabel())
                            <p class="irdc-programme-card__component">{{ $programme->componentLabel() }}</p>
                        @endif
                        <h2 class="irdc-programme-card__title">{{ $programme->title }}</h2>
                        @if($programme->summary)
                            <p class="irdc-programme-card__summary">{{ $programme->summary }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="irdc-programmes-empty">
                    @if($selectedComponent)
                        No programmes published under Component {{ $selectedComponent->component_number }} yet.
                    @else
                        Programmes are being updated.
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
