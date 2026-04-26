@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit download</h2>
    <div class="card feature-card p-4">
        <p class="small">Current: <a href="{{ route('download.file', $download) }}">Test download (public)</a></p>
        <form method="POST" action="{{ route('admin.downloads.update', $download) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $download->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $download->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Replace file (optional)</label>
                <input type="file" name="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Document date (optional)</label>
                <input type="date" name="file_date" class="form-control" value="{{ old('file_date', $download->file_date?->format('Y-m-d')) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Sort order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $download->sort_order) }}" min="0">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" @selected(old('status', $download->status)==='draft')>Draft</option>
                    <option value="published" @selected(old('status', $download->status)==='published')>Published</option>
                </select>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
