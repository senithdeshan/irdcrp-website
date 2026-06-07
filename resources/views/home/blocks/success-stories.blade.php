{{-- 6. Success stories slider --}}
<section
    class="irdc-success relative overflow-hidden py-20 sm:py-24"
    x-data="{
        stories: @js($successStories),
        i: 0,
        timer: null,
        viewportWidth: 0,
        cardGap() {
            return window.innerWidth < 640 ? 12 : 16;
        },
        cardStep() {
            return this.cardWidth() + this.cardGap();
        },
        get visible() {
            const total = Math.max(this.stories.length, 1);
            if (window.innerWidth >= 1024) return Math.min(4, total);
            if (window.innerWidth >= 640) return Math.min(2, total);
            return 1;
        },
        get pages() {
            return Math.max(this.stories.length - this.visible + 1, 1);
        },
        next() { this.i = (this.i + 1) % this.pages; },
        prev() { this.i = (this.i - 1 + this.pages) % this.pages; },
        goTo(idx) { this.i = idx; },
        cardWidth() {
            const gap = this.cardGap();
            const totalGaps = gap * Math.max(this.visible - 1, 0);
            const available = Math.max((this.viewportWidth || window.innerWidth) - totalGaps, 240);
            return Math.max(available / this.visible, 220);
        },
        start() {
            this.stop();
            if (this.pages > 1) {
                this.timer = setInterval(() => this.next(), 5500);
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
            this.i = Math.min(this.i, this.pages - 1);
            this.start();
        }
    }"
    x-init="syncLayout(); window.addEventListener('resize', () => syncLayout())"
    @mouseenter="stop()"
    @mouseleave="start()"
>
    <div class="irdc-success__bg absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-success__overlay absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-success__wave irdc-success__wave--top" aria-hidden="true">
        <svg viewBox="0 0 1200 72" preserveAspectRatio="none" class="h-10 w-full sm:h-12">
            <path fill="currentColor" d="M0,48 C150,8 300,64 450,32 C600,0 750,40 900,24 C1050,8 1100,32 1200,16 L1200,72 L0,72 Z"/>
        </svg>
    </div>
    <div class="irdc-success__wave irdc-success__wave--bottom" aria-hidden="true">
        <svg viewBox="0 0 1200 72" preserveAspectRatio="none" class="h-10 w-full sm:h-12">
            <path fill="currentColor" d="M0,48 C150,8 300,64 450,32 C600,0 750,40 900,24 C1050,8 1100,32 1200,16 L1200,72 L0,72 Z"/>
        </svg>
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="mx-auto mb-10 max-w-3xl text-center sm:mb-12">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-800/80 sm:text-sm">Success Stories</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-[#0A3D62] sm:text-4xl">Farmer Success Stories</h2>
            <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                Real experiences from farming communities supported through climate-resilient livelihoods.
            </p>
        </header>

        <div x-ref="viewport" class="relative overflow-hidden">
            <div
                class="flex gap-4 transition-transform duration-700 ease-out"
                :style="`transform: translateX(-${i * cardStep()}px);`"
            >
                @forelse ($successStories as $story)
                    <article class="shrink-0 pb-2" :style="`width: ${cardWidth()}px`">
                        <div class="irdc-success-card group">
                            <div class="flex min-w-0 items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate text-base font-extrabold text-[#1B5E20] sm:text-lg">{{ $story->name }}</h3>
                                    <p class="truncate text-xs font-bold uppercase tracking-wide text-[#8B4A1F]/95 sm:text-sm">{{ $story->location }} - {{ $story->province }}</p>
                                </div>
                                <span class="irdc-success-quote-top" aria-hidden="true">&ldquo;</span>
                            </div>
                            <p class="irdc-success-story-text mt-3 text-sm leading-relaxed text-slate-700 sm:text-[0.95rem]">{{ $story->story }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <img
                                        src="{{ asset('storage/'.$story->photo) }}"
                                        alt="{{ $story->name }}"
                                        class="h-16 w-16 shrink-0 rounded-full object-cover ring-2 ring-white sm:h-20 sm:w-20"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                    <div class="irdc-success-rating-badge">
                                        {!! str_repeat('&#9733;', max(1, (int) ($story->rating ?? 5))) !!}
                                    </div>
                                </div>
                                <span class="text-xl text-[#43A047]" aria-hidden="true">&rdquo;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="shrink-0 pb-2" :style="`width: ${cardWidth()}px`">
                        <div class="irdc-success-card">
                            <h3 class="text-base font-extrabold text-[#1B5E20] sm:text-lg">No success stories yet</h3>
                            <p class="mt-3 text-sm leading-relaxed text-slate-700">Add active stories from the admin panel to display them here.</p>
                        </div>
                    </article>
                @endforelse
            </div>

            <button
                type="button"
                @click="prev()"
                class="irdc-success-nav irdc-success-nav--left"
                aria-label="Previous success story"
            >&lsaquo;</button>
            <button
                type="button"
                @click="next()"
                class="irdc-success-nav irdc-success-nav--right"
                aria-label="Next success story"
            >&rsaquo;</button>
        </div>

        <div class="mt-7 flex items-center justify-center gap-2.5">
            <template x-for="dot in pages" :key="'dot-' + dot">
                <button
                    type="button"
                    @click="goTo(dot - 1)"
                    class="h-2.5 rounded-full transition-all duration-300"
                    :class="i === (dot - 1) ? 'w-8 bg-[#43A047]' : 'w-2.5 bg-emerald-900/25 hover:bg-emerald-700/55'"
                    aria-label="Go to success story page"
                ></button>
            </template>
        </div>
    </div>
</section>
