@extends('layouts.app')
@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Gallery Media</h2>
            <p class="text-muted mb-0">Manage Audio, Photos, Videos, Presentation, and Voice of people.</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-green">Add media</a>
    </div>

    <form method="GET" class="mb-4 d-flex flex-wrap align-items-center gap-2">
        <label for="category" class="small text-muted">Category</label>
        <select id="category" name="category" class="form-select form-select-sm" style="max-width: 240px;" onchange="this.form.submit()">
            <option value="">All categories</option>
            @foreach(\App\Models\Gallery::CATEGORIES as $slug => $label)
                <option value="{{ $slug }}" @selected($category === $slug)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card feature-card overflow-hidden h-100">
                    <div class="ratio ratio-16x9 bg-light d-flex align-items-center justify-content-center">
                        @if($item->media_type === 'image' && $item->mediaUrl())
                            <img src="{{ $item->mediaUrl() }}" alt="" class="object-fit-cover w-100 h-100">
                        @elseif($item->media_type === 'video' && $item->mediaUrl() && ! $item->external_url)
                            <video src="{{ $item->mediaUrl() }}" class="w-100 h-100 object-fit-cover" muted></video>
                        @else
                            <div class="text-center p-4">
                                <div class="display-6 fw-bold text-success">{{ strtoupper(substr($item->mediaTypeLabel(), 0, 1)) }}</div>
                                <p class="small text-muted mb-0">{{ $item->mediaTypeLabel() }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge text-bg-success">{{ $item->categoryLabel() }}</span>
                            <span class="badge text-bg-secondary">{{ $item->mediaTypeLabel() }}</span>
                            <span class="badge text-bg-{{ $item->status === 'published' ? 'primary' : 'light' }}">{{ $item->status }}</span>
                        </div>
                        <h3 class="h6 fw-bold mb-1">{{ $item->title }}</h3>
                        <p class="text-muted small mb-3">{{ $item->item_date?->format('Y-m-d') ?? '-' }}</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                            @if($item->mediaUrl())
                                <a href="{{ $item->mediaUrl() }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Open</a>
                            @endif
                            <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete this media item?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No media items found.</p>
        @endforelse
    </div>
</section>
@endsection
