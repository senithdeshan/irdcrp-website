{{-- 2. Programmes --}}
<section id="programmes" class="irdc-home-programmes irdc-reveal-on-scroll irdc-scroll-mt-header">
    <div class="mx-auto max-w-[118rem] px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <header class="irdc-home-programmes__head">
            <p class="irdc-home-programmes__eyebrow">{{ __('messages.home_programmes_eyebrow') }}</p>
            <h2 class="irdc-home-programmes__title">{{ __('messages.home_programmes_title') }}</h2>
            <p class="irdc-home-programmes__lead">{{ __('messages.home_programmes_sub') }}</p>
        </header>
        <div class="irdc-programmes-grid irdc-programmes-grid--home">
            @if($programmes->isNotEmpty())
                @foreach($programmes as $programme)
                    <a
                        href="{{ route('programmes.show', $programme) }}"
                        class="irdc-programme-card group"
                    >
                        <div class="irdc-programme-card__image">
                            <img
                                src="{{ $programme->coverImageUrl() }}"
                                alt="{{ $programme->title }}"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <div class="irdc-programme-card__body">
                            <h3 class="irdc-programme-card__title">{{ $programme->title }}</h3>
                            @if($programme->summary)
                                <p class="irdc-programme-card__summary">{{ $programme->summary }}</p>
                            @endif
                            <span class="irdc-programme-card__cta">Explore programme</span>
                        </div>
                    </a>
                @endforeach
            @elseif($programmeCards->isNotEmpty())
                @foreach($programmeCards as $card)
                    @php
                        $cardId = (string) ($card['id'] ?? '');
                        $cardSummaryKey = $cardId !== '' ? 'messages.prog_'.$cardId.'_desc' : '';
                        $cardTitle = $cardId !== '' ? __('messages.prog_'.$cardId) : '';
                        $cardSummary = $cardSummaryKey !== '' ? __($cardSummaryKey) : '';
                        $cardImage = isset($card['image']) ? asset(ltrim((string) $card['image'], '/')) : asset('images/hero/hero-home-01.png');
                    @endphp
                    <article class="irdc-programme-card group">
                        <div class="irdc-programme-card__image">
                            <img
                                src="{{ $cardImage }}"
                                alt="{{ filled($cardTitle) ? $cardTitle : __('messages.nav_programmes') }}"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <div class="irdc-programme-card__body">
                            @if(filled($cardTitle))
                                <h3 class="irdc-programme-card__title">{{ $cardTitle }}</h3>
                            @endif
                            @if(filled($cardSummary) && lang()->has($cardSummaryKey))
                                <p class="irdc-programme-card__summary">{{ $cardSummary }}</p>
                            @endif
                            <span class="irdc-programme-card__cta">Explore programme</span>
                        </div>
                    </article>
                @endforeach
            @else
                <div class="irdc-programmes-empty">Programmes are being updated.</div>
            @endif
        </div>
        <div class="mt-12 text-center">
            <a href="{{ route('programmes.index') }}" class="irdc-home-programmes__link">View all programmes</a>
        </div>
    </div>
</section>
