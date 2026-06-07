@extends('layouts.app')

@section('content')
@php
    $summaryRows = old('summary', $projectAreas['summary'] ?? []);
    for ($i = count($summaryRows); $i < 6; $i++) {
        $summaryRows[] = ['label' => '', 'value' => ''];
    }

    $tableRows = old('table_rows', $projectAreas['table_rows'] ?? []);
    for ($i = count($tableRows); $i < 8; $i++) {
        $tableRows[] = ['district' => '', 'ds_divisions' => '', 'focus' => ''];
    }
@endphp

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Project areas</h1>
            <p class="text-muted mb-0">Update the public Project Areas page image, coverage summary, and district-wise table.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the details.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.project-areas.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Page headings</h2>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="hero-title" class="form-label">Hero title</label>
                    <input id="hero-title" type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $projectAreas['hero_title'] ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="hero-subtitle" class="form-label">Hero subtitle</label>
                    <input id="hero-subtitle" type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $projectAreas['hero_subtitle'] ?? '') }}">
                </div>

                <div class="col-md-6">
                    <label for="section-title" class="form-label">Section title</label>
                    <input id="section-title" type="text" name="section_title" class="form-control" value="{{ old('section_title', $projectAreas['section_title'] ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="section-subtitle" class="form-label">Section subtitle</label>
                    <input id="section-subtitle" type="text" name="section_subtitle" class="form-control" value="{{ old('section_subtitle', $projectAreas['section_subtitle'] ?? '') }}">
                </div>
            </div>
        </div>

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Coverage summary</h2>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="summary-title" class="form-label">Summary title</label>
                    <input id="summary-title" type="text" name="summary_title" class="form-control" value="{{ old('summary_title', $projectAreas['summary_title'] ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="summary-image" class="form-label">Coverage image</label>
                    <input id="summary-image" type="file" name="summary_image" class="form-control" accept="image/png,image/jpeg,image/webp">
                    @if(!empty($projectAreas['summary_image']))
                        <div class="mt-3 d-flex align-items-center gap-3">
                            <img src="{{ asset($projectAreas['summary_image']) }}" alt="Current coverage image" class="rounded border bg-white" style="height: 150px; width: 96px; object-fit: contain;">
                            <span class="text-muted small">Current image</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 35%;">Label</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($summaryRows as $index => $row)
                            <tr>
                                <td>
                                    <input type="text" name="summary[{{ $index }}][label]" class="form-control" value="{{ $row['label'] ?? '' }}" placeholder="Province">
                                </td>
                                <td>
                                    <input type="text" name="summary[{{ $index }}][value]" class="form-control" value="{{ $row['value'] ?? '' }}" placeholder="To be updated">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card feature-card p-4">
            <h2 class="h5 fw-bold mb-3">District-wise table</h2>

            <div class="mb-4">
                <label for="table-title" class="form-label">Table title</label>
                <input id="table-title" type="text" name="table_title" class="form-control" value="{{ old('table_title', $projectAreas['table_title'] ?? '') }}" required>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Column 1 heading</label>
                    <input type="text" name="table_headings[district]" class="form-control" value="{{ old('table_headings.district', $projectAreas['table_headings']['district'] ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Column 2 heading</label>
                    <input type="text" name="table_headings[ds_divisions]" class="form-control" value="{{ old('table_headings.ds_divisions', $projectAreas['table_headings']['ds_divisions'] ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Column 3 heading</label>
                    <input type="text" name="table_headings[focus]" class="form-control" value="{{ old('table_headings.focus', $projectAreas['table_headings']['focus'] ?? '') }}" required>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>District</th>
                            <th>DS Divisions</th>
                            <th>Main Focus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tableRows as $index => $row)
                            <tr>
                                <td>
                                    <input type="text" name="table_rows[{{ $index }}][district]" class="form-control" value="{{ $row['district'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" name="table_rows[{{ $index }}][ds_divisions]" class="form-control" value="{{ $row['ds_divisions'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" name="table_rows[{{ $index }}][focus]" class="form-control" value="{{ $row['focus'] ?? '' }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-text">Blank rows will not be shown on the public page.</div>
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-green">Save project areas</button>
                <a href="{{ url('/areas') }}" target="_blank" class="btn btn-outline-secondary">View Project Areas</a>
            </div>
        </div>
    </form>
</section>
@endsection
