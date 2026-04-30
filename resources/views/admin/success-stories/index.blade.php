@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Success stories</h2>
        <a href="{{ route('admin.success-stories.create') }}" class="btn btn-green">Add story</a>
    </div>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card feature-card overflow-hidden h-100">
                    <div class="ratio ratio-16x9 bg-light">
                        <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}" class="object-fit-cover w-100 h-100">
                    </div>
                    <div class="card-body p-3">
                        <p class="small mb-1 fw-bold">{{ $item->name }}</p>
                        <p class="text-muted small mb-2">{{ $item->location }} - {{ $item->province }}</p>
                        <p class="small mb-2">{{ \Illuminate\Support\Str::limit($item->story, 110) }}</p>
                        <p class="small mb-2">
                            <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($item->status) }}</span>
                            <span class="ms-2 text-warning">{{ str_repeat('★', (int) $item->rating) }}</span>
                        </p>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.success-stories.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.success-stories.destroy', $item) }}" onsubmit="return confirm('Delete this story?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No success stories yet.</p>
        @endforelse
    </div>
</section>
@endsection
