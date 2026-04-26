@extends('layouts.app')

@section('content')

@php
    $maxHeights = [380, 270, 340, 300, 360];
    $galleryJson = $items->map(function ($item) {
        return [
            'src' => asset('storage/'.$item->image),
            'title' => $item->title,
            'date' => $item->item_date?->format('M j, Y') ?? null,
        ];
    })->values();
@endphp

{{-- Page title: two-tone (brand + “Gallery” word) --}}
<section class="border-b border-stone-200/90 bg-gradient-to-b from-stone-50 to-white">
    <div class="max-w-6xl mx-auto px-4 py-10 sm:py-14 text-center">
        <h1 class="font-display text-3xl sm:text-4xl md:text-[2.4rem] font-extrabold tracking-tight leading-tight">
            <span class="text-slate-800">IRDCRP</span>
            <span class="text-[#6B2B27]"> {{ __('messages.nav_gallery') }}</span>
        </h1>
        <p class="mt-3 max-w-2xl mx-auto text-slate-500 text-sm sm:text-base">
            {{ __('messages.gallery_masonry_lead') }}
        </p>
    </div>
</section>

{{-- Masonry + Alpine lightbox (same-page popup, prev/next) --}}
<section
    class="max-w-7xl mx-auto px-3 sm:px-6 py-8 sm:py-12"
    x-data="{
        items: @js($galleryJson),
        i: 0,
        isOpen: false,
        setBodyScroll(lock) { document.body.classList.toggle('overflow-hidden', lock) },
        openAt(index) { this.i = index; this.isOpen = true; this.setBodyScroll(true) },
        close() { this.isOpen = false; this.setBodyScroll(false) },
        next() { this.i = (this.i + 1) % this.items.length },
        prev() { this.i = (this.i - 1 + this.items.length) % this.items.length },
    }"
    @keydown.window="if (isOpen) { if ($event.key === 'Escape') { close() } else if ($event.key === 'ArrowRight' && items.length) { next() } else if ($event.key === 'ArrowLeft' && items.length) { prev() } }"
>
    @forelse($items as $item)
        @if($loop->first)
            <div class="columns-1 sm:columns-2 lg:columns-3 [column-fill:_balance] gap-4 sm:gap-5">
        @endif
        <article class="mb-4 sm:mb-5 break-inside-avoid group">
            <div class="overflow-hidden rounded-2xl bg-stone-100 ring-1 ring-stone-200/70 shadow-sm transition duration-300 hover:shadow-lg hover:ring-stone-300/90">
                <button
                    type="button"
                    @click="openAt({{ $loop->index }})"
                    class="block w-full text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 rounded-t-2xl"
                >
                    <div class="relative w-full overflow-hidden bg-stone-200/50">
                        <img
                            src="{{ asset('storage/'.$item->image) }}"
                            alt="{{ $item->title }}"
                            class="w-full h-auto object-cover object-center transition duration-500 group-hover:scale-[1.02]"
                            style="max-height: {{ $maxHeights[$loop->index % 5] }}px"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                </button>
                <div class="border-t border-stone-200/60 bg-white px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-b-2xl">
                    <p class="text-sm font-semibold text-slate-800 leading-snug line-clamp-2">{{ $item->title }}</p>
                    @if($item->item_date)
                        <p class="mt-0.5 text-xs text-slate-500">{{ $item->item_date->format('M j, Y') }}</p>
                    @endif
                </div>
            </div>
        </article>
        @if($loop->last)
            </div>
        @endif
    @empty
        <div class="rounded-2xl border border-dashed border-stone-300 bg-stone-50/80 px-6 py-16 text-center">
            <p class="text-slate-500 max-w-md mx-auto">{{ __('messages.gallery_empty') }}</p>
        </div>
    @endforelse

    <template x-teleport="body">
        <div
            x-show="isOpen && items.length"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[200] flex items-center justify-center p-2 sm:p-4 bg-slate-900/88 backdrop-blur-sm"
            role="dialog"
            aria-modal="true"
            :aria-label="items[i] && items[i].title"
            @click.self="close()"
        >
            <div
                class="relative flex w-full max-w-5xl flex-col"
                @click.stop
            >
                <div class="relative flex min-h-0 max-h-[90vh] items-center justify-center">
                    <button
                        type="button"
                        x-show="items.length > 1"
                        @click="prev()"
                        class="absolute left-0 sm:left-1 z-10 flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20"
                        aria-label="{{ __('messages.gallery_lightbox_prev') }}"
                    >
                        <span class="text-2xl leading-none" aria-hidden="true">‹</span>
                    </button>
                    <div class="mx-10 sm:mx-14 min-h-0 flex-1 flex items-center justify-center">
                        <img
                            :src="items[i] && items[i].src"
                            :alt="items[i] && items[i].title"
                            class="max-h-[85vh] w-auto max-w-full rounded-lg object-contain shadow-2xl"
                            decoding="async"
                        >
                    </div>
                    <button
                        type="button"
                        x-show="items.length > 1"
                        @click="next()"
                        class="absolute right-0 sm:right-1 z-10 flex h-10 w-10 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20"
                        aria-label="{{ __('messages.gallery_lightbox_next') }}"
                    >
                        <span class="text-2xl leading-none" aria-hidden="true">›</span>
                    </button>
                </div>
                <div class="mt-2 flex flex-col items-center gap-1 text-center sm:mt-3">
                    <p x-text="items[i] && items[i].title" class="text-sm sm:text-base font-semibold text-white max-w-2xl px-2"></p>
                    <p x-show="items[i] && items[i].date" x-text="items[i] && items[i].date" class="text-xs text-white/80"></p>
                    <p x-show="items.length > 1" class="text-xs text-white/50" x-text="(i + 1) + ' / ' + items.length"></p>
                </div>
                <button
                    type="button"
                    @click="close()"
                    class="absolute -top-0 right-0 z-20 flex h-10 w-10 items-center justify-center rounded-full text-white/90 transition hover:bg-white/10 hover:text-white"
                    aria-label="{{ __('messages.gallery_lightbox_close') }}"
                >
                    <span class="text-2xl leading-none" aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    </template>
</section>

@endsection
