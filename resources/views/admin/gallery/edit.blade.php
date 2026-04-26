@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit gallery item</h2>
    <div class="card feature-card p-4" style="max-width: 540px;">
        <div class="mb-3">
            <img src="{{ asset('storage/'.$gallery->image) }}" alt="" class="img-fluid rounded" style="max-height: 200px;">
        </div>
        <form method="POST" action="{{ route('admin.gallery.update', $gallery) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date (optional)</label>
                <input type="date" name="item_date" class="form-control" value="{{ old('item_date', $gallery->item_date?->format('Y-m-d')) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Replace image (optional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
