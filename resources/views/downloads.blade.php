@extends('layouts.app')

@section('title', __('messages.nav_downloads').' | '.config('app.name'))

@section('content')
<section class="irdc-safeguard-hero">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-3xl">
            <p class="irdc-safeguard-hero__eyebrow">Resources</p>
            <h1 class="irdc-safeguard-hero__title">{{ __('messages.nav_downloads') }}</h1>
            <p class="irdc-safeguard-hero__lead">
                Reports, guidelines, forms, and official project documents published by IRDCRP for public download.
            </p>
        </div>
    </div>
</section>

<section class="irdc-safeguard-section">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
        <header class="mb-8 max-w-3xl">
            <h2 class="font-display text-2xl font-extrabold tracking-tight text-[#0A3D62] sm:text-3xl">Document library</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">
                Important IRDCRP documents available for download.
            </p>
        </header>

        <div class="irdc-safeguard-table-wrap">
            <table class="irdc-safeguard-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                        <th scope="col">Document</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($downloads as $doc)
                        <tr>
                            <td data-label="#">{{ $loop->iteration }}</td>
                            <td data-label="Title">
                                <strong class="irdc-safeguard-table__title">{{ $doc->title }}</strong>
                            </td>
                            <td data-label="Description">
                                @if ($doc->description)
                                    <div class="irdc-safeguard-table__description">{{ $doc->description }}</div>
                                @else
                                    <span class="irdc-safeguard-table__muted">—</span>
                                @endif
                            </td>
                            <td data-label="Date">
                                @if ($doc->file_date)
                                    {{ $doc->file_date->format('M j, Y') }}
                                @else
                                    <span class="irdc-safeguard-table__muted">—</span>
                                @endif
                            </td>
                            <td data-label="Document">
                                @if ($doc->fileExists())
                                    <a href="{{ route('download.file', $doc) }}" class="irdc-safeguard-download">
                                        <span class="irdc-safeguard-download__badge">{{ $doc->fileExtension() ?: 'FILE' }}</span>
                                        <span class="irdc-safeguard-download__text">
                                            <span class="irdc-safeguard-download__label">{{ $doc->fileTypeLabel() }}</span>
                                            @if ($doc->file_original_name)
                                                <span class="irdc-safeguard-download__name">{{ $doc->file_original_name }}</span>
                                            @endif
                                        </span>
                                    </a>
                                @else
                                    <span class="irdc-safeguard-table__muted">No file</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="irdc-safeguard-table__empty">
                                No published documents yet. Content will appear here once added from the admin Downloads area.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
