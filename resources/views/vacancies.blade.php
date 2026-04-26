@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">{{ __('messages.nav_vacancies') }}</h1>
        <p class="lead mb-0">Vacancy notices and application documents (PDF)</p>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        @forelse($items as $v)
            <div class="col-12 col-md-6">
                <div class="card feature-card p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <h2 class="h5 fw-bold mb-0">{{ $v->title }}</h2>
                        @if($v->status === 'open' && $v->isOpenForPublic())
                            <span class="badge text-bg-success">Open</span>
                        @else
                            <span class="badge text-bg-secondary">Closed</span>
                        @endif
                    </div>
                    <p class="small text-muted mb-2">Deadline: <strong>{{ $v->deadline->format('F j, Y') }}</strong></p>
                    <p class="small flex-grow-1">{{ \Illuminate\Support\Str::limit(strip_tags($v->description), 220) }}</p>
                    <a href="{{ route('vacancies.show', $v) }}" class="btn btn-green btn-sm align-self-start">View details &amp; PDF</a>
                </div>
            </div>
        @empty
            <p class="text-muted">No vacancies published yet.</p>
        @endforelse
    </div>
</section>

@endsection
