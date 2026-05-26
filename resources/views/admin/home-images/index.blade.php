@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Home page images</h2>
            <p class="text-muted mb-0">Change the seven hero slider images shown on the home page.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @foreach($items as $item)
            <div class="col-md-6 col-xl-4">
                <div class="card feature-card h-100 overflow-hidden">
                    <img
                        src="{{ $item->imageUrl() }}"
                        alt="{{ $item->title }}"
                        class="w-100"
                        style="height: 180px; object-fit: cover;"
                    >
                    <div class="card-body">
                        <div class="d-flex justify-content-between gap-3">
                            <h3 class="h5 fw-bold mb-1">{{ $item->title }}</h3>
                            <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }} align-self-start">
                                {{ $item->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </div>
                        <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($item->caption, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Slide {{ $item->sort_order }}</span>
                            <a href="{{ route('admin.home-images.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
