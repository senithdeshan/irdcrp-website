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
        <div class="irdc-programmes-grid">
            @forelse($programmes as $programme)
                <a href="{{ route('programmes.show', $programme) }}" class="irdc-programme-card group">
                    <div class="irdc-programme-card__image">
                        <img src="{{ $programme->coverImageUrl() }}" alt="{{ $programme->title }}" loading="lazy" decoding="async">
                    </div>
                    <div class="irdc-programme-card__body">
                        <p class="irdc-programme-card__number">Programme {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                        <h2 class="irdc-programme-card__title">{{ $programme->title }}</h2>
                        @if($programme->summary)
                            <p class="irdc-programme-card__summary">{{ $programme->summary }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="irdc-programmes-empty">Programmes are being updated.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
