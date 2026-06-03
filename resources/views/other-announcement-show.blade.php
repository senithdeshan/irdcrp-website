@extends('layouts.app')

@section('title', $otherAnnouncement->title.' | '.config('app.name'))

@section('content')

<section class="irdc-procurement-hero">
    <div class="container">
        <p class="irdc-procurement-hero__eyebrow">
            <a href="{{ route('other-announcements.index') }}" class="text-white-50 text-decoration-none">← {{ __('messages.nav_other_announcements') }}</a>
        </p>
        <h1>{{ $otherAnnouncement->title }}</h1>
        @if ($otherAnnouncement->published_date)
            <p>Published: <strong>{{ $otherAnnouncement->published_date->format('F j, Y') }}</strong></p>
        @endif
    </div>
</section>

<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card feature-card p-4 mb-4">
                <div style="white-space: pre-wrap;">{!! nl2br(e($otherAnnouncement->description)) !!}</div>
            </div>
            @if ($otherAnnouncement->documentExists())
                <a class="btn btn-green" href="{{ route('other-announcements.file', $otherAnnouncement) }}">
                    Download {{ $otherAnnouncement->documentTypeLabel() }}
                </a>
            @endif
        </div>
    </div>
</section>

@endsection
