@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add gallery image</h2>
    <div class="card feature-card p-4" style="max-width: 540px;">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date (optional)</label>
                <input type="date" name="item_date" class="form-control" value="{{ old('item_date') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-green">Upload</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
