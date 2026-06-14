@extends('layouts.app')

@section('content')
@php
    $projectAreas = $projectAreas ?? app(\App\Support\SiteSettings::class)->projectAreas();
    $summaryRows = collect($projectAreas['summary'] ?? [])->filter(fn ($row) => filled($row['label'] ?? null) || filled($row['value'] ?? null));
    $tableRows = collect($projectAreas['table_rows'] ?? [])->filter(fn ($row) => filled($row['district'] ?? null) || filled($row['ds_divisions'] ?? null) || filled($row['focus'] ?? null));
    $summaryImageUrl = !empty($projectAreas['summary_image']) ? asset($projectAreas['summary_image']) : null;
    $summaryImageAlt = $projectAreas['summary_title'] ?? 'Coverage Summary';
@endphp

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">{{ $projectAreas['hero_title'] ?? 'Project Areas' }}</h1>
        @if(filled($projectAreas['hero_subtitle'] ?? null))
            <p class="lead mb-0">{{ $projectAreas['hero_subtitle'] }}</p>
        @endif
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">{{ $projectAreas['section_title'] ?? 'Geographical Coverage' }}</h2>
        @if(filled($projectAreas['section_subtitle'] ?? null))
            <p class="section-subtitle">{{ $projectAreas['section_subtitle'] }}</p>
        @endif
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card feature-card p-4 overflow-hidden">
                @if($summaryImageUrl)
                    <div
                        class="irdc-areas-image-preview mb-4"
                        x-data="{ open: false }"
                        @keydown.escape.window="open = false"
                    >
                        <button
                            type="button"
                            class="irdc-areas-image-preview__trigger w-100 border-0 bg-transparent p-0"
                            @click="open = true"
                            aria-label="View full coverage image"
                        >
                            <img
                                src="{{ $summaryImageUrl }}"
                                alt="{{ $summaryImageAlt }}"
                                class="rounded border bg-white w-100"
                                style="height: min(520px, 80vh); object-fit: contain;"
                            >
                        </button>

                        <template x-teleport="body">
                            <div
                                x-show="open"
                                x-cloak
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="irdc-areas-lightbox"
                                role="dialog"
                                aria-modal="true"
                                aria-label="{{ $summaryImageAlt }}"
                                @click.self="open = false"
                            >
                                <button
                                    type="button"
                                    class="irdc-areas-lightbox__close"
                                    @click="open = false"
                                    aria-label="Close full image view"
                                >
                                    <span aria-hidden="true">×</span>
                                </button>
                                <img
                                    src="{{ $summaryImageUrl }}"
                                    alt="{{ $summaryImageAlt }}"
                                    class="irdc-areas-lightbox__image"
                                    decoding="async"
                                >
                            </div>
                        </template>
                    </div>
                @endif
                <h4 class="fw-bold text-success">{{ $projectAreas['summary_title'] ?? 'Coverage Summary' }}</h4>
                @forelse($summaryRows as $row)
                    <p><strong>{{ $row['label'] ?? '' }}:</strong> {{ $row['value'] ?? '' }}</p>
                @empty
                    <p class="text-muted mb-0">Coverage summary will be updated soon.</p>
                @endforelse
            </div>
        </div>

        <div class="col-lg-7">
            <div class="irdc-areas-table-card">
                <div class="irdc-areas-table-card__head">
                    <div>
                        <p class="irdc-areas-table-card__eyebrow">Coverage table</p>
                        <h4 class="irdc-areas-table-card__title">{{ $projectAreas['table_title'] ?? 'District-wise Areas' }}</h4>
                    </div>
                    <span class="irdc-areas-table-card__count">{{ $tableRows->count() }} areas</span>
                </div>

                <div class="irdc-areas-table-wrap">
                    <table class="irdc-areas-table">
                        <thead>
                            <tr>
                                <th>{{ $projectAreas['table_headings']['district'] ?? 'District' }}</th>
                                <th>{{ $projectAreas['table_headings']['ds_divisions'] ?? 'DS Divisions' }}</th>
                                <th>{{ $projectAreas['table_headings']['focus'] ?? 'Main Focus' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tableRows as $row)
                                <tr>
                                    <td data-label="{{ $projectAreas['table_headings']['district'] ?? 'District' }}">
                                        <span class="irdc-areas-table__district">{{ $row['district'] ?? '' }}</span>
                                    </td>
                                    <td data-label="{{ $projectAreas['table_headings']['ds_divisions'] ?? 'DS Divisions' }}">
                                        <span class="irdc-areas-table__division">{{ $row['ds_divisions'] ?? '' }}</span>
                                    </td>
                                    <td data-label="{{ $projectAreas['table_headings']['focus'] ?? 'Main Focus' }}">
                                        <span class="irdc-areas-table__focus">{{ $row['focus'] ?? '' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="irdc-areas-table__empty">District-wise areas will be updated soon.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
