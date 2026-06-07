@extends('layouts.app')

@section('title', __('messages.nav_other_announcements').' | '.config('app.name'))

@section('content')

<section class="irdc-procurement-hero">
    <div class="container">
        <p class="irdc-procurement-hero__eyebrow">Announcements</p>
        <h1>{{ __('messages.nav_other_announcements') }}</h1>
        <p>General project announcements, circulars, and notices that are not procurement or vacancy related.</p>
    </div>
</section>

<section class="irdc-procurement-section">
    <div class="container">
        <div class="irdc-procurement-head">
            <p>Other announcements</p>
            <h2>Official notices and supporting documents</h2>
            <span>Browse published announcements and download attached files when available.</span>
        </div>

        <div class="irdc-procurement-list">
            @forelse ($items as $item)
                <article class="irdc-procurement-card">
                    <div class="irdc-procurement-card__meta">
                        <span>{{ $item->published_date?->format('M j, Y') ?: 'Date to be updated' }}</span>
                        <strong>Announcement</strong>
                    </div>

                    <div class="irdc-procurement-card__body">
                        <div>
                            <h3>{{ $item->title }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($item->description, 260) }}</p>
                        </div>
                    </div>

                    <div class="irdc-procurement-card__docs">
                        @if ($item->documentExists())
                            <a href="{{ route('other-announcements.file', $item) }}">
                                <span>{{ $item->documentExtension() ?: 'FILE' }}</span>
                                <strong>{{ $item->documentTypeLabel() }}</strong>
                                <small>{{ $item->document_original_name ?: 'Download document' }}</small>
                            </a>
                        @endif
                        <a href="{{ route('other-announcements.show', $item) }}" class="irdc-procurement-card__view-link">
                            <span>View</span>
                            <strong>Read full notice</strong>
                            <small>Open announcement details</small>
                        </a>
                    </div>
                </article>
            @empty
                <div class="irdc-procurement-empty">
                    <h3>No other announcements published yet</h3>
                    <p>General project notices will appear here once added from the admin area.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
