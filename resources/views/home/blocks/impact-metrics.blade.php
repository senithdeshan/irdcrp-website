{{-- 3. Impact / statistics --}}
<section class="hidden">
    <div class="container max-w-6xl">
        <header class="irdc-section-head irdc-section-head--emerald">
            <p class="irdc-section-head__eyebrow">{{ __('messages.home_stats_eyebrow') }}</p>
            <h2 class="irdc-section-head__title">{{ __('messages.home_stats_title') }}</h2>
            <p class="irdc-section-head__lead">{{ __('messages.home_stats_sub') }}</p>
        </header>
        <div class="mt-10 grid grid-cols-2 gap-4 sm:mt-12 lg:grid-cols-4 lg:gap-6" data-reveal-stagger>
            <article class="irdc-stat-tile">
                @php
                    $districts = (string) ($stats['districts'] ?? '00');
                @endphp
                <p class="font-display text-4xl font-extrabold tabular-nums text-[#0A3D62] sm:text-5xl md:text-6xl lg:text-6xl" data-countup data-target="{{ (int) preg_replace('/\D+/', '', $districts) }}">{{ $districts }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_districts') }}</p>
            </article>
            <article class="irdc-stat-tile">
                @php
                    $beneficiaries = (string) ($stats['beneficiaries'] ?? '00');
                @endphp
                <p class="font-display text-4xl font-extrabold tabular-nums text-emerald-800 sm:text-5xl md:text-6xl lg:text-6xl" data-countup data-target="{{ (int) preg_replace('/\D+/', '', $beneficiaries) }}">{{ $beneficiaries }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_beneficiaries') }}</p>
            </article>
            <article class="irdc-stat-tile">
                @php
                    $farmers = (string) ($stats['farmers'] ?? '00');
                @endphp
                <p class="font-display text-4xl font-extrabold tabular-nums text-[#0A3D62] sm:text-5xl md:text-6xl lg:text-6xl" data-countup data-target="{{ (int) preg_replace('/\D+/', '', $farmers) }}">{{ $farmers }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_farmers') }}</p>
            </article>
            <article class="irdc-stat-tile">
                <p class="font-display text-3xl font-extrabold tabular-nums text-emerald-800 sm:text-4xl md:text-5xl lg:text-6xl">{!! e($stats['duration'] ?? null) ?: '&mdash;' !!}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 sm:text-sm">{{ __('messages.stat_duration') }}</p>
            </article>
        </div>
    </div>
</section>

{{-- 3b. Weather — single modern card (image + district picker + forecast) --}}
<section class="irdc-impact-section irdc-reveal-on-scroll">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <div class="irdc-impact-shell">
            <div class="irdc-impact-intro">
                <p class="irdc-impact-eyebrow">{{ __('messages.home_stats_eyebrow') }}</p>
                <h2 class="irdc-impact-title">Agriculture resilience in numbers</h2>
                <p class="irdc-impact-lead">
                    Key implementation indicators for climate-smart agriculture, value chain support, and resilient rural livelihoods in Sri Lanka.
                </p>
            </div>
            <div class="irdc-impact-grid" data-reveal-stagger>
                @foreach($impactMetrics as $metric)
                    @php
                        $countTarget = (int) ($metric->count_target ?? 0);
                        $displayValue = (string) ($metric->value ?? '');
                    @endphp
                    <article class="irdc-impact-card irdc-impact-card--{{ $metric->key ?? 'metric' }}">
                        <span class="irdc-impact-card__icon" aria-hidden="true">
                            @switch($metric->key ?? '')
                                @case('beneficiaries')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 19c0-2.2-1.8-4-4-4s-4 1.8-4 4"/><path d="M12 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M20 18c0-1.7-1-3.1-2.5-3.7"/><path d="M17 6.4a2.5 2.5 0 0 1 0 4.2"/></svg>
                                    @break
                                @case('investment')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 18V8l8-4 8 4v10"/><path d="M7 18v-6h10v6"/><path d="M3 20h18"/></svg>
                                    @break
                                @case('projects')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/><path d="M8 5v14"/></svg>
                                    @break
                                @default
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 20h16"/><path d="M6 20V9l6-5 6 5v11"/><path d="M9 20v-6h6v6"/></svg>
                            @endswitch
                        </span>
                        <p class="irdc-impact-card__value">
                            @if($countTarget > 0 && preg_match('/^[0-9,]+$/', $displayValue))
                                <span data-countup data-target="{{ $countTarget }}">{{ $displayValue }}</span>
                            @else
                                {{ $displayValue }}
                            @endif
                        </p>
                        <h3 class="irdc-impact-card__label">{{ $metric->label }}</h3>
                        @if(filled($metric->helper))
                            <p class="irdc-impact-card__helper">{{ $metric->helper }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
