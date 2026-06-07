@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Latest insights</h2>
        <a href="{{ route('admin.latest-insights.create') }}" class="btn btn-green">Add insight</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card feature-card overflow-hidden h-100">
                    <div class="ratio ratio-16x9 bg-light">
                        <img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}" class="object-fit-cover w-100 h-100">
                    </div>
                    <div class="card-body p-3">
                        <p class="small mb-1 fw-bold">{{ $item->title }}</p>
                        <p class="text-muted small mb-2">
                            {{ $item->category ?: 'Insight' }}
                            @if($item->insight_date)
                                - {{ $item->insight_date->format('M j, Y') }}
                            @endif
                        </p>
                        <p class="small mb-2">{{ \Illuminate\Support\Str::limit($item->summary, 120) }}</p>
                        @if($item->hasLink())
                            <p class="small mb-2 text-truncate">
                                <span class="text-muted">Link:</span>
                                <a href="{{ $item->linkHref() }}" class="text-decoration-none" @if($item->linkOpensInNewTab()) target="_blank" rel="noopener noreferrer" @endif>{{ $item->linkHref() }}</a>
                            </p>
                        @endif
                        <p class="small mb-2">
                            <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span>
                        </p>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.latest-insights.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.latest-insights.destroy', $item) }}" onsubmit="return confirm('Delete this insight?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No latest insights yet.</p>
        @endforelse
    </div>
</section>
@endsection
