@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Edit {{ $homeImage->title }}</h2>
        <a href="{{ route('admin.home-images.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card feature-card overflow-hidden">
                <img
                    src="{{ $homeImage->imageUrl() }}"
                    alt="{{ $homeImage->title }}"
                    class="w-100"
                    style="height: 280px; object-fit: cover;"
                >
                <div class="card-body">
                    <p class="small text-muted mb-0">
                        Current image. Uploading a new file replaces this slide image.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <form method="POST" action="{{ route('admin.home-images.update', $homeImage) }}" enctype="multipart/form-data" class="card feature-card p-4">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $homeImage->title) }}" maxlength="120" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Slide order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $homeImage->sort_order) }}" min="1" max="7" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        @php($activeOld = old('is_active', (int) $homeImage->is_active))
                        <select name="is_active" class="form-select" required>
                            <option value="1" @selected((string) $activeOld === '1')>Active</option>
                            <option value="0" @selected((string) $activeOld === '0')>Hidden</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Caption</label>
                        <textarea name="caption" class="form-control" rows="4" maxlength="500">{{ old('caption', $homeImage->caption) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">New image</label>
                        <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <p class="small text-muted mt-2 mb-0">Accepted: JPG, PNG, WEBP. Max size: 8 MB.</p>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-green">Save image</button>
                    <a href="{{ route('admin.home-images.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
