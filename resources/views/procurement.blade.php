@extends('layouts.app')

@section('content')

<section class="irdc-procurement-hero">
    <div class="container">
        <p class="irdc-procurement-hero__eyebrow">Announcements</p>
        <h1>Procurement</h1>
        <p>Procurement notices, bidding documents, award information, and related PDF reports published by IRDCRP.</p>
    </div>
</section>

<section class="irdc-procurement-section">
    <div class="container">
        <div class="irdc-procurement-head">
            <p>Procurement Notices</p>
            <h2>Open opportunities and published procurement records</h2>
            <span>Download the main notice PDF and any supporting report PDFs attached to each item.</span>
        </div>

        <div class="irdc-procurement-list">
            @forelse($items as $notice)
                @php
                    $closed = $notice->isClosed();
                    $documents = $notice->documents ?? [];
                @endphp

                <article class="irdc-procurement-card {{ $closed ? 'irdc-procurement-card--closed' : '' }}">
                    <div class="irdc-procurement-card__meta">
                        <span>{{ $notice->reference_no ?: 'No reference' }}</span>
                        <strong>{{ ucfirst($notice->notice_type) }}</strong>
                    </div>

                    <div class="irdc-procurement-card__body">
                        <div>
                            <h3>{{ $notice->title }}</h3>
                            @if(filled($notice->description))
                                <p>{{ $notice->description }}</p>
                            @endif
                        </div>

                        <dl>
                            <div>
                                <dt>Published</dt>
                                <dd>{{ $notice->published_date?->format('Y-m-d') ?: 'To be updated' }}</dd>
                            </div>
                            <div>
                                <dt>Closing</dt>
                                <dd>{{ $notice->closing_date?->format('Y-m-d') ?: 'To be updated' }}</dd>
                            </div>
                            <div>
                                <dt>Status</dt>
                                <dd>
                                    <span class="irdc-procurement-status {{ $closed ? 'irdc-procurement-status--closed' : '' }}">
                                        {{ $closed ? 'Closed' : 'Open' }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="irdc-procurement-card__docs">
                        @forelse($documents as $index => $document)
                            <a href="{{ route('procurement.file', [$notice, $index]) }}" target="_blank" rel="noopener">
                                <span>PDF</span>
                                <strong>{{ $document['label'] ?? 'Procurement PDF' }}</strong>
                                <small>{{ $document['original_name'] ?? 'Download document' }}</small>
                            </a>
                        @empty
                            <span class="irdc-procurement-card__empty">PDF documents will be added soon.</span>
                        @endforelse
                    </div>
                </article>
            @empty
                <div class="irdc-procurement-empty">
                    <h3>No procurement notices published yet</h3>
                    <p>Official procurement opportunities and related documents of IRDCRP will be published here.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
