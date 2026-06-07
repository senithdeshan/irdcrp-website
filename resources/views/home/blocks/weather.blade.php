<section
    id="weather-areas"
    class="irdc-scroll-mt-header irdc-weather-section relative border-b border-stone-200/80 bg-gradient-to-b from-emerald-50/70 via-[#f8faf8] to-white py-16 sm:py-20 md:py-24"
    x-data="irdcWeather(@js($weatherWidget))"
>
    <span class="irdc-weather-section__blob irdc-weather-section__blob--1" aria-hidden="true"></span>
    <span class="irdc-weather-section__blob irdc-weather-section__blob--2" aria-hidden="true"></span>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="mx-auto mb-10 max-w-4xl text-center sm:mb-12">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800/80 sm:text-sm">{{ __('messages.home_weather_eyebrow') }}</p>
            <h2 class="mt-3 font-display text-2xl font-extrabold leading-snug tracking-tight text-[#3d2f1f] sm:text-3xl md:text-[1.75rem] lg:text-4xl">
                {{ __('messages.home_weather_title') }}
            </h2>
        </header>

        <div class="irdc-weather-mega">
            <div class="irdc-weather-mega__grid">
                {{-- Left: hero photo + organic backdrop --}}
                <div class="irdc-weather-mega__visual">
                    <div class="irdc-weather-mega__visual-blob" aria-hidden="true"></div>
                    <figure class="irdc-weather-deckle irdc-weather-deckle--hero relative z-[1] mx-auto max-w-md lg:mx-0">
                        <img
                            :src="areaImage()"
                            alt="{{ __('messages.home_weather_image_alt') }}"
                            width="520"
                            height="900"
                            loading="lazy"
                            decoding="async"
                            class="min-h-[12rem] w-full bg-stone-100"
                        >
                    </figure>
                </div>

                {{-- Right: embedded widget (districts | forecast) --}}
                <div class="irdc-weather-mega__widget">
                    <div class="irdc-weather-widget-shell">
                        {{-- District list --}}
                        <div class="irdc-weather-widget-shell__districts">
                            <p class="irdc-weather-widget-label" x-text="strings.districts"></p>
                            <div
                                class="irdc-weather-district-list"
                                role="listbox"
                                aria-label="{{ __('messages.weather_districts_label') }}"
                            >
                                <template x-for="(a, idx) in areas" :key="a.id">
                                    <button
                                        type="button"
                                        class="irdc-weather-district-btn"
                                        :class="{ 'irdc-weather-district-btn--active': selected === idx }"
                                        role="option"
                                        :aria-selected="selected === idx ? 'true' : 'false'"
                                        @click="select(idx)"
                                    >
                                        <span x-text="a.name[locale] || a.name.en"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- Forecast --}}
                        <div class="irdc-weather-widget-shell__forecast">
                            <p class="irdc-weather-panel-head">
                                <span class="text-slate-500" x-text="districtLabel()"></span>
                                <span class="text-slate-300">&middot;</span>
                                <span x-text="strings.weather"></span>
                            </p>

                            <div x-show="loading" x-cloak class="irdc-weather-state irdc-weather-state--loading">
                                <span class="h-9 w-9 animate-spin rounded-full border-2 border-[#5a4a1f] border-t-transparent" aria-hidden="true"></span>
                                <span class="mt-3 text-sm text-slate-600" x-text="strings.loading"></span>
                            </div>

                            <div x-show="!loading && error" x-cloak class="irdc-weather-state text-sm text-amber-900/95" role="alert">
                                <span x-text="strings.error"></span>
                            </div>

                            <div x-show="!loading && !error && payload" x-cloak class="irdc-weather-forecast-body">
                                <div class="irdc-weather-current">
                                    <div class="irdc-weather-current__icon" aria-hidden="true">
                                        <svg x-show="iconKind(currentCode()) === 'sun'" class="absolute inset-0 h-full w-full text-amber-500" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><circle cx="32" cy="32" r="14"/><path d="M32 6v6M32 52v6M6 32h6M52 32h6M13.6 13.6l4.2 4.2M46.2 46.2l4.2 4.2M13.6 50.4l4.2-4.2M46.2 17.8l4.2-4.2"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'cloud'" class="absolute inset-0 h-full w-full text-slate-500" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 40h36a10 10 0 0 0 0-20 13 13 0 0 0-25-4 10 10 0 0 0-19 6" fill="currentColor" fill-opacity="0.12"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'rain' || iconKind(currentCode()) === 'drizzle' || iconKind(currentCode()) === 'thunder'" class="absolute inset-0 h-full w-full text-sky-600" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 36h36a9 9 0 0 0 0-18 12 12 0 0 0-23-3 9 9 0 0 0-17 5" fill="currentColor" fill-opacity="0.1"/><path d="M22 46v8M32 44v10M42 46v8" stroke="currentColor"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'snow'" class="absolute inset-0 h-full w-full text-sky-400" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 34h30a8 8 0 0 0 0-16 11 11 0 0 0-21-2 8 8 0 0 0-15 4" fill="currentColor" fill-opacity="0.1"/><path d="m32 42-4 4m4-4 4 4m-4-4v8"/></svg>
                                        <svg x-show="iconKind(currentCode()) === 'fog'" class="absolute inset-0 h-full w-full text-slate-400" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 28h40M10 36h44M14 44h36" stroke-linecap="round"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-display text-4xl font-extrabold tabular-nums text-[#3d2f1f] sm:text-5xl">
                                            <span x-text="currentTemp() !== null ? currentTemp() + '\u00B0C' : '\u2014'"></span>
                                        </p>
                                        <p class="mt-1.5 text-sm font-medium capitalize text-slate-600" x-text="condLabel(currentCode())"></p>
                                    </div>
                                </div>

                                <div class="irdc-weather-week">
                                    <p class="irdc-weather-week__title" x-text="strings.forecast"></p>
                                    <ul class="irdc-weather-week__list">
                                        <template x-for="row in dailyRows()" :key="row.date">
                                            <li class="irdc-weather-week__row">
                                                <span class="irdc-weather-week__day" x-text="formatDayShort(row.date)"></span>
                                                <span class="irdc-weather-week__ico relative inline-flex h-5 w-5 shrink-0 items-center justify-center" aria-hidden="true">
                                                    <svg x-show="iconKind(row.code) === 'sun'" class="absolute inset-0 m-auto h-5 w-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'cloud'" class="absolute inset-0 m-auto h-5 w-5 text-slate-500" viewBox="0 0 24 24" fill="currentColor" opacity="0.45"><path d="M5 16h12a4 4 0 0 0 0-8 6 6 0 0 0-11-2 4 4 0 0 0-7 3"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'rain' || iconKind(row.code) === 'thunder' || iconKind(row.code) === 'drizzle'" class="absolute inset-0 m-auto h-5 w-5 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 14h11a3.5 3.5 0 0 0 0-7 5 5 0 0 0-9.5-1.5A3.5 3.5 0 0 0 5 14Z" fill="currentColor" fill-opacity="0.15"/><path d="M9 18v3M12 17v4M15 18v3"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'snow'" class="absolute inset-0 m-auto h-5 w-5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 13h10a3 3 0 0 0 0-6 4 4 0 0 0-8-.5A3 3 0 0 0 6 13Z" fill="currentColor" fill-opacity="0.15"/></svg>
                                                    <svg x-show="iconKind(row.code) === 'fog'" class="absolute inset-0 m-auto h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 10h16M3 14h18M5 18h14" stroke-linecap="round"/></svg>
                                                </span>
                                                <span class="irdc-weather-week__hi" x-text="Math.round(row.max) + '\u00B0'"></span>
                                                <span class="irdc-weather-week__lo" x-text="Math.round(row.min) + '\u00B0'"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                                <p class="irdc-weather-attrib">
                                    <a href="https://open-meteo.com/" rel="noopener noreferrer" target="_blank" class="transition hover:text-slate-700">{{ __('messages.weather_attribution') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
