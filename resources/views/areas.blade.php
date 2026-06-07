@extends('layouts.app')

@section('content')
@php
    $projectAreas = $projectAreas ?? app(\App\Support\SiteSettings::class)->projectAreas();
    $summaryRows = collect($projectAreas['summary'] ?? [])->filter(fn ($row) => filled($row['label'] ?? null) || filled($row['value'] ?? null));
    $tableRows = collect($projectAreas['table_rows'] ?? [])->filter(fn ($row) => filled($row['district'] ?? null) || filled($row['ds_divisions'] ?? null) || filled($row['focus'] ?? null));
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
                @if(!empty($projectAreas['summary_image']))
                    <img
                        src="{{ asset($projectAreas['summary_image']) }}"
                        alt="{{ $projectAreas['summary_title'] ?? 'Coverage Summary' }}"
                        class="rounded border bg-white mb-4 w-100"
                        style="height: min(520px, 80vh); object-fit: contain;"
                    >
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
            <div class="card feature-card p-4">
                <h4 class="fw-bold">{{ $projectAreas['table_title'] ?? 'District-wise Areas' }}</h4>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>{{ $projectAreas['table_headings']['district'] ?? 'District' }}</th>
                                <th>{{ $projectAreas['table_headings']['ds_divisions'] ?? 'DS Divisions' }}</th>
                                <th>{{ $projectAreas['table_headings']['focus'] ?? 'Main Focus' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tableRows as $row)
                                <tr>
                                    <td>{{ $row['district'] ?? '' }}</td>
                                    <td>{{ $row['ds_divisions'] ?? '' }}</td>
                                    <td>{{ $row['focus'] ?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted">District-wise areas will be updated soon.</td>
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
