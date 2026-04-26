@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">{{ __('messages.nav_downloads') }}</h1>
        <p class="lead mb-0">Reports, guidelines, forms and official project documents</p>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Document library</h2>
        <p class="section-subtitle">Important IRDCRP documents for public download.</p>
    </div>

    <div class="row g-4">
        @forelse($downloads as $doc)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card feature-card p-4 h-100 d-flex flex-column">
                    <div class="icon-circle">📄</div>
                    <h5 class="fw-bold">{{ $doc->title }}</h5>
                    @if($doc->description)
                        <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($doc->description, 180) }}</p>
                    @endif
                    @if($doc->file_date)
                        <p class="small text-muted mb-2">Dated: {{ $doc->file_date->format('M j, Y') }}</p>
                    @endif
                    <a href="{{ route('download.file', $doc) }}" class="btn btn-green btn-sm align-self-start">Download</a>
                </div>
            </div>
        @empty
            <p class="text-muted col-12">No published documents yet. Add files from the admin &rarr; Downloads.</p>
        @endforelse
    </div>
</section>

@endsection
