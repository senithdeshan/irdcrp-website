@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">News & Events</h1>
        <p class="lead mb-0">Latest updates, events and announcements of IRDCRP</p>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        @forelse($news as $item)
            <div class="col-md-4">
                <div class="card feature-card">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" style="height:200px; width:100%; object-fit:cover;">
                    @else
                        <div style="height:200px; background:#EAF7F0;" class="d-flex align-items-center justify-content-center">
                            <span class="fs-1">📰</span>
                        </div>
                    @endif

                    <div class="card-body p-4">
                        <small class="text-success fw-bold">{{ $item->published_date ?? 'No date' }}</small>
                        <h5 class="fw-bold mt-2">{{ $item->title_en }}</h5>
                        <p>{{ Str::limit($item->content_en, 120) }}</p>
                        <a href="{{ route('news.show', $item->id) }}" class="btn btn-green btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="card feature-card p-5">
                    <h5 class="fw-bold">No news available yet.</h5>
                </div>
            </div>
        @endforelse
    </div>
</section>

@endsection