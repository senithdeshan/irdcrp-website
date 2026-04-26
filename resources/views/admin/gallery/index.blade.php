@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Gallery</h2>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-green">Add image</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card feature-card overflow-hidden h-100">
                    <div class="ratio ratio-4x3 bg-light">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="" class="object-fit-cover w-100 h-100">
                    </div>
                    <div class="card-body p-2">
                        <p class="small mb-1 fw-bold">{{ $item->title }}</p>
                        <p class="text-muted small mb-2">{{ $item->item_date?->format('Y-m-d') ?? '—' }}</p>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No images yet.</p>
        @endforelse
    </div>
</section>
@endsection
