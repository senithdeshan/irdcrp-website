{{-- Latest insights — slider (all active items) --}}
<section
    class="irdc-insights relative overflow-hidden py-12 sm:py-14"
    x-data="{
        totalItems: {{ max($latestInsights->count(), 1) }},
        i: 0,
        timer: null,
        viewportWidth: 0,
        cardGap() {
            return window.innerWidth < 640 ? 12 : 16;
        },
        cardStep() {
            return this.cardWidth() + this.cardGap();
        },
        get total() {
            return this.totalItems;
        },
        get visible() {
            if (window.innerWidth >= 1024) return Math.min(3, this.total);
            if (window.innerWidth >= 640) return Math.min(2, this.total);
            return 1;
        },
        get pages() {
            return Math.max(this.total - this.visible + 1, 1);
        },
        next() { this.i = (this.i + 1) % this.pages; },
        prev() { this.i = (this.i - 1 + this.pages) % this.pages; },
        goTo(idx) { this.i = idx; },
        cardWidth() {
            const gap = this.cardGap();
            const viewport = Math.max(this.viewportWidth || window.innerWidth, 280);
            const maxCardWidth = 340;
            const minCardWidth = 280;
            const totalGaps = gap * Math.max(this.visible - 1, 0);
            const fitWidth = (viewport - totalGaps) / this.visible;

            return Math.max(minCardWidth, Math.min(maxCardWidth, Math.floor(fitWidth)));
        },
        trackFillsViewport() {
            const trackWidth = (this.total * this.cardWidth()) + (Math.max(this.total - 1, 0) * this.cardGap());
            return trackWidth >= ((this.viewportWidth || window.innerWidth) - 8);
        },
        start() {
            this.stop();
            if (this.pages > 1) {
                this.timer = setInterval(() => this.next(), 6000);
            }
        },
        stop() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
        syncLayout() {
            this.viewportWidth = this.$refs.viewport ? this.$refs.viewport.clientWidth : window.innerWidth;
            this.i = Math.min(this.i, Math.max(this.pages - 1, 0));
            this.start();
        }
    }"
    x-init="syncLayout(); window.addEventListener('resize', () => syncLayout())"
    @mouseenter="stop()"
    @mouseleave="start()"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="irdc-insights-head">
            <h2 class="irdc-insights-head__title">Latest Insights</h2>
            <p class="irdc-insights-head__subtitle">Project updates from the field</p>
            <p class="irdc-insights-head__lead">Approved highlights, lessons, and implementation notes from IRDCRP activities.</p>
        </header>

        <div x-ref="viewport" class="irdc-insights-slider relative overflow-hidden">
            <div
                x-ref="track"
                class="flex gap-4 transition-transform duration-700 ease-out"
                :class="!trackFillsViewport() ? 'justify-center' : ''"
                :style="`transform: translateX(-${i * cardStep()}px);`"
            >
                @forelse ($latestInsights as $insight)
                    <article class="shrink-0 pb-2" :style="`width: ${cardWidth()}px`">
                        @if($insight->hasLink())
                            <a
                                href="{{ $insight->linkHref() }}"
                                class="irdc-insight-card irdc-insight-card--linked group block h-full no-underline text-inherit"
                                @if($insight->linkOpensInNewTab()) target="_blank" rel="noopener noreferrer" @endif
                            >
                                <div class="irdc-insight-card__image">
                                    <img
                                        src="{{ $insight->imageUrl() }}"
                                        alt="{{ $insight->title }}"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                </div>
                                <div class="irdc-insight-card__body">
                                    <div class="irdc-insight-card__meta">
                                        <span>{{ $insight->category ?: 'Insight' }}</span>
                                        @if($insight->insight_date)
                                            <time datetime="{{ $insight->insight_date->toDateString() }}">{{ $insight->insight_date->format('M j, Y') }}</time>
                                        @endif
                                    </div>
                                    <h3>{{ $insight->title }}</h3>
                                    <p>{{ $insight->summary }}</p>
                                    <span class="irdc-insight-card__cta">View update</span>
                                </div>
                            </a>
                        @else
                            <div class="irdc-insight-card h-full">
                                <div class="irdc-insight-card__image">
                                    <img
                                        src="{{ $insight->imageUrl() }}"
                                        alt="{{ $insight->title }}"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                </div>
                                <div class="irdc-insight-card__body">
                                    <div class="irdc-insight-card__meta">
                                        <span>{{ $insight->category ?: 'Insight' }}</span>
                                        @if($insight->insight_date)
                                            <time datetime="{{ $insight->insight_date->toDateString() }}">{{ $insight->insight_date->format('M j, Y') }}</time>
                                        @endif
                                    </div>
                                    <h3>{{ $insight->title }}</h3>
                                    <p>{{ $insight->summary }}</p>
                                </div>
                            </div>
                        @endif
                    </article>
                @empty
                    <article class="shrink-0 pb-2" :style="`width: ${cardWidth()}px`">
                        <div class="irdc-insight-card irdc-insight-card--empty h-full">
                            <div class="irdc-insight-card__body">
                                <span class="irdc-insight-card__empty-label">Latest Insights</span>
                                <h3>No latest insights yet</h3>
                                <p>Add an insight from the admin panel and set it to Active to display it here.</p>
                            </div>
                        </div>
                    </article>
                @endforelse
            </div>

            @if($latestInsights->count() > 1)
                <button
                    type="button"
                    @click="prev()"
                    class="irdc-insights-nav irdc-insights-nav--left"
                    aria-label="Previous insight"
                >&lsaquo;</button>
                <button
                    type="button"
                    @click="next()"
                    class="irdc-insights-nav irdc-insights-nav--right"
                    aria-label="Next insight"
                >&rsaquo;</button>
            @endif
        </div>

        @if($latestInsights->count() > 1)
            <div class="mt-7 flex items-center justify-center gap-2.5">
                <template x-for="dot in pages" :key="'insight-dot-' + dot">
                    <button
                        type="button"
                        @click="goTo(dot - 1)"
                        class="h-2.5 rounded-full transition-all duration-300"
                        :class="i === (dot - 1) ? 'w-8 bg-[#0A3D62]' : 'w-2.5 bg-slate-400/35 hover:bg-slate-500/55'"
                        :aria-label="'Go to insight slide ' + dot"
                    ></button>
                </template>
            </div>
        @endif
    </div>
</section>
