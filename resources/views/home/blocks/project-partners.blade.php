{{-- Project partners — above footer, after vacancies --}}
@if(($projectPartners ?? collect())->isNotEmpty())
<section class="irdc-partners" aria-labelledby="project-partners-title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="irdc-partners__head">
            <h2 id="project-partners-title" class="irdc-partners__title">Relevant Stakeholders &amp; Project Partners</h2>
            <span class="irdc-partners__line" aria-hidden="true"></span>
        </header>

        <div
            class="irdc-partners-slider relative"
            x-data="{
                totalItems: {{ max($projectPartners->count(), 1) }},
                i: 0,
                timer: null,
                viewportWidth: 0,
                cardGap() {
                    return window.innerWidth < 640 ? 12 : 16;
                },
                cardStep() {
                    return this.cardSize() + this.cardGap();
                },
                cardSize() {
                    const w = window.innerWidth;
                    if (w >= 1280) return 212;
                    if (w >= 768) return 200;
                    if (w >= 640) return 188;
                    return 172;
                },
                slideHeight() {
                    return this.cardSize() + 58;
                },
                get visible() {
                    if (window.innerWidth >= 1280) return Math.min(4, this.totalItems);
                    if (window.innerWidth >= 768) return Math.min(3, this.totalItems);
                    if (window.innerWidth >= 640) return Math.min(2, this.totalItems);
                    return 1;
                },
                get pages() {
                    return Math.max(this.totalItems - this.visible + 1, 1);
                },
                next() { this.i = (this.i + 1) % this.pages; },
                prev() { this.i = (this.i - 1 + this.pages) % this.pages; },
                goTo(idx) { this.i = idx; },
                start() {
                    this.stop();
                    if (this.pages > 1) {
                        this.timer = setInterval(() => this.next(), 7000);
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
            <div x-ref="viewport" class="irdc-partners-slider__viewport overflow-hidden">
                <div
                    class="flex transition-transform duration-700 ease-out"
                    :style="`gap: ${cardGap()}px; transform: translateX(-${i * cardStep()}px);`"
                >
                    @foreach ($projectPartners as $partner)
                        <article
                            class="irdc-partners-slide shrink-0"
                            :style="`width: ${cardSize()}px; min-height: ${slideHeight()}px`"
                        >
                            @if($partner->hasWebsite())
                                <a
                                    href="{{ $partner->website_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="irdc-partners-card irdc-partners-card--linked group"
                                    aria-label="{{ $partner->name }} (opens in new tab)"
                                    title="{{ $partner->name }}"
                                    :style="`height: ${cardSize()}px`"
                                >
                                    <img
                                        src="{{ $partner->logoUrl() }}"
                                        alt="{{ $partner->name }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="irdc-partners-card__logo"
                                    >
                                </a>
                            @else
                                <div class="irdc-partners-card" title="{{ $partner->name }}" :style="`height: ${cardSize()}px`">
                                    <img
                                        src="{{ $partner->logoUrl() }}"
                                        alt="{{ $partner->name }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="irdc-partners-card__logo"
                                    >
                                </div>
                            @endif
                            <p class="irdc-partners-card__name">{{ $partner->name }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            <template x-if="pages > 1">
                <div>
                    <button
                        type="button"
                        @click="prev()"
                        class="irdc-partners-nav irdc-partners-nav--left"
                        aria-label="Previous partners"
                    >&lsaquo;</button>
                    <button
                        type="button"
                        @click="next()"
                        class="irdc-partners-nav irdc-partners-nav--right"
                        aria-label="Next partners"
                    >&rsaquo;</button>
                </div>
            </template>

            @if($projectPartners->count() > 1)
                <div class="mt-5 flex items-center justify-center gap-2">
                    <template x-for="dot in pages" :key="'partner-dot-' + dot">
                        <button
                            type="button"
                            @click="goTo(dot - 1)"
                            class="h-2.5 rounded-full transition-all duration-300"
                            :class="i === (dot - 1) ? 'w-8 bg-[#0A3D62]' : 'w-2.5 bg-slate-300 hover:bg-emerald-300'"
                            :aria-label="'Go to partner slide ' + dot"
                        ></button>
                    </template>
                </div>
            @endif
        </div>
    </div>
</section>
@endif
