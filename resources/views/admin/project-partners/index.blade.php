@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Project partners</h2>
            <p class="text-muted mb-0">Manage stakeholder logos shown on the home page above the footer.</p>
        </div>
        <a href="{{ route('admin.project-partners.create') }}" class="btn btn-green">Add partner</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card feature-card h-100 overflow-hidden">
                    <div class="irdc-admin-partner-logo-preview bg-light d-flex align-items-center justify-content-center p-4">
                        <img src="{{ $item->logoUrl() }}" alt="{{ $item->name }}" class="img-fluid" style="max-height: 72px; object-fit: contain;">
                    </div>
                    <div class="card-body p-3">
                        <p class="small fw-bold mb-1">{{ $item->name }}</p>
                        @if($item->hasWebsite())
                            <p class="small text-truncate mb-2">
                                <a href="{{ $item->website_url }}" target="_blank" rel="noopener noreferrer">{{ $item->website_url }}</a>
                            </p>
                        @else
                            <p class="small text-muted mb-2">No website link</p>
                        @endif
                        <p class="small mb-2">
                            <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                            <span class="text-muted ms-1">Order {{ $item->sort_order }}</span>
                        </p>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.project-partners.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.project-partners.destroy', $item) }}" onsubmit="return confirm('Delete this partner?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No project partners yet. Add logos to display them on the home page.</p>
        @endforelse
    </div>
</section>
@endsection
