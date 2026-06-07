@extends('layouts.app')

@section('title', 'Reports | '.config('app.name'))

@section('content')
<section class="irdc-safeguard-hero">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-3xl">
            <p class="irdc-safeguard-hero__eyebrow">Resources</p>
            <h1 class="irdc-safeguard-hero__title">Reports</h1>
            <p class="irdc-safeguard-hero__lead">
                Official project reports, progress updates, monitoring documents, and supporting files published by IRDCRP.
            </p>
        </div>
    </div>
</section>

<section class="irdc-safeguard-section">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="irdc-safeguard-table-wrap">
            <table class="irdc-safeguard-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                        <th scope="col">Report</th>
                        <th scope="col">Images</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        @php
                            $imageUrls = $item->imageUrls();
                        @endphp
                        <tr>
                            <td data-label="#">{{ $loop->iteration }}</td>
                            <td data-label="Title">
                                <strong class="irdc-safeguard-table__title">{{ $item->title }}</strong>
                            </td>
                            <td data-label="Description">
                                @if ($item->description)
                                    <div class="irdc-safeguard-table__description">{{ $item->description }}</div>
                                @else
                                    <span class="irdc-safeguard-table__muted">—</span>
                                @endif
                            </td>
                            <td data-label="Date">
                                @if ($item->document_date)
                                    {{ $item->document_date->format('M j, Y') }}
                                @else
                                    <span class="irdc-safeguard-table__muted">—</span>
                                @endif
                            </td>
                            <td data-label="Report">
                                @if ($item->documentExists())
                                    <a href="{{ route('reports.download', $item) }}" class="irdc-safeguard-download">
                                        <span class="irdc-safeguard-download__badge">{{ $item->documentExtension() ?: 'FILE' }}</span>
                                        <span class="irdc-safeguard-download__text">
                                            <span class="irdc-safeguard-download__label">{{ $item->documentTypeLabel() }}</span>
                                            @if ($item->document_original_name)
                                                <span class="irdc-safeguard-download__name">{{ $item->document_original_name }}</span>
                                            @endif
                                        </span>
                                    </a>
                                @else
                                    <span class="irdc-safeguard-table__muted">No file</span>
                                @endif
                            </td>
                            <td data-label="Images">
                                @if (count($imageUrls) > 0)
                                    <div
                                        class="irdc-safeguard-gallery"
                                        x-data="{
                                            images: @js($imageUrls),
                                            active: 0,
                                            open: false,
                                            show(index) { this.active = index; this.open = true; },
                                            close() { this.open = false; },
                                            next() { this.active = (this.active + 1) % this.images.length; },
                                            previous() { this.active = (this.active - 1 + this.images.length) % this.images.length; },
                                        }"
                                        x-on:keydown.window.escape="open && close()"
                                        x-on:keydown.window.arrow-right="open && next()"
                                        x-on:keydown.window.arrow-left="open && previous()"
                                    >
                                        <div class="irdc-safeguard-gallery__thumbs">
                                            @foreach ($imageUrls as $imageUrl)
                                                <button
                                                    type="button"
                                                    class="irdc-safeguard-gallery__thumb"
                                                    x-on:click="show({{ $loop->index }})"
                                                    aria-label="View image {{ $loop->iteration }}"
                                                >
                                                    <img src="{{ $imageUrl }}" alt="" loading="lazy" decoding="async">
                                                </button>
                                            @endforeach
                                        </div>

                                        <div
                                            x-show="open"
                                            x-cloak
                                            x-transition.opacity
                                            class="irdc-news-lightbox"
                                            role="dialog"
                                            aria-modal="true"
                                            aria-label="Report image viewer"
                                        >
                                            <button type="button" class="irdc-news-lightbox__backdrop" x-on:click="close()" aria-label="Close image viewer"></button>
                                            <div class="irdc-news-lightbox__panel">
                                                <button type="button" class="irdc-news-lightbox__close" x-on:click="close()" aria-label="Close">×</button>
                                                <button type="button" class="irdc-news-lightbox__nav irdc-news-lightbox__nav--prev" x-on:click="previous()" aria-label="Previous image">‹</button>
                                                <img :src="images[active]" alt="" class="irdc-news-lightbox__image">
                                                <button type="button" class="irdc-news-lightbox__nav irdc-news-lightbox__nav--next" x-on:click="next()" aria-label="Next image">›</button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="irdc-safeguard-table__muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="irdc-safeguard-table__empty">
                                No published reports yet. Content will appear here once added from the admin Reports area.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
