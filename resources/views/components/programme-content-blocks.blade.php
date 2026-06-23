@props(['programme'])

@php
    $blocks = $programme->normalizedContentBlocks();
    $imageLightboxItems = collect($blocks)
        ->filter(fn ($block) => ($block['type'] ?? null) === 'image' && filled($block['path'] ?? null))
        ->map(fn ($block) => [
            'src' => $programme->storageImageUrl($block['path']),
            'alt' => $block['caption'] ?? $programme->title,
            'caption' => $block['caption'] ?? null,
        ])
        ->values()
        ->all();
    $imageIndex = -1;
@endphp

@if (count($blocks) > 0)
    <div
        class="irdc-programme-blocks"
        x-data="{
            images: @js($imageLightboxItems),
            active: 0,
            open: false,
            show(index) {
                this.active = index;
                this.open = true;
            },
            close() {
                this.open = false;
            },
            next() {
                this.active = (this.active + 1) % this.images.length;
            },
            previous() {
                this.active = (this.active - 1 + this.images.length) % this.images.length;
            },
        }"
        x-on:keydown.window.escape="close()"
        x-on:keydown.window.arrow-right="open && images.length > 1 && next()"
        x-on:keydown.window.arrow-left="open && images.length > 1 && previous()"
    >
        @foreach ($blocks as $block)
            @if (($block['type'] ?? null) === 'text' && filled($block['body'] ?? null))
                <div class="irdc-programme-block irdc-programme-block--text">
                    <div class="irdc-programme-block__text">{!! nl2br(e($block['body'])) !!}</div>
                </div>
            @elseif (($block['type'] ?? null) === 'image' && filled($block['path'] ?? null))
                @php $imageIndex++; @endphp
                <figure class="irdc-programme-block irdc-programme-block--image">
                    <button
                        type="button"
                        class="irdc-programme-block__image-button"
                        x-on:click="show({{ $imageIndex }})"
                        aria-label="Open full screen image"
                    >
                        <img
                            src="{{ $programme->storageImageUrl($block['path']) }}"
                            alt="{{ $block['caption'] ?? $programme->title }}"
                            loading="lazy"
                            decoding="async"
                        >
                    </button>
                    @if (filled($block['caption'] ?? null))
                        <figcaption>{{ $block['caption'] }}</figcaption>
                    @endif
                </figure>
            @elseif (($block['type'] ?? null) === 'table' && filled($block['headers'] ?? null))
                <div class="irdc-programme-block irdc-programme-block--table">
                    @if (filled($block['title'] ?? null))
                        <h3 class="irdc-programme-block__table-title">{{ $block['title'] }}</h3>
                    @endif
                    <div class="irdc-programme-block__table-wrap">
                        <table class="irdc-programme-block__table">
                            <thead>
                                <tr>
                                    @foreach ($block['headers'] as $header)
                                        <th scope="col">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($block['rows'] ?? [] as $row)
                                    @if (filled(array_filter($row)))
                                        <tr>
                                            @foreach ($block['headers'] as $cellIndex => $header)
                                                <td data-label="{{ $header }}">{{ $row[$cellIndex] ?? '' }}</td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach

        @if (count($imageLightboxItems) > 0)
            <template x-teleport="body">
                <div
                    x-show="open"
                    x-cloak
                    x-transition.opacity
                    class="irdc-news-lightbox irdc-programme-lightbox"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Programme image viewer"
                >
                    <button type="button" class="irdc-news-lightbox__backdrop" x-on:click="close()" aria-label="Close image viewer"></button>
                    <div class="irdc-news-lightbox__panel">
                        <div class="irdc-news-lightbox__top">
                            <span x-text="(active + 1) + ' / ' + images.length"></span>
                            <button type="button" x-on:click="close()" aria-label="Close image viewer">Close</button>
                        </div>

                        <div class="irdc-news-lightbox__stage">
                            <button type="button" class="irdc-news-lightbox__nav" x-on:click="previous()" aria-label="Previous image" x-show="images.length > 1">&lsaquo;</button>
                            <img :src="images[active]?.src" :alt="images[active]?.alt || ''">
                            <button type="button" class="irdc-news-lightbox__nav" x-on:click="next()" aria-label="Next image" x-show="images.length > 1">&rsaquo;</button>
                        </div>

                        <p class="irdc-programme-lightbox__caption" x-show="images[active]?.caption" x-text="images[active]?.caption"></p>

                        <div class="irdc-news-lightbox__thumbs" x-show="images.length > 1">
                            <template x-for="(image, index) in images" :key="image.src">
                                <button type="button" x-on:click="active = index" :class="{ 'is-active': active === index }" aria-label="View programme image">
                                    <img :src="image.src" :alt="image.alt || ''">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        @endif
    </div>
@endif
