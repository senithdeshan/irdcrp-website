@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add download</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.downloads.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">File (max 25 MB, PDF, Office, ZIP)</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Document date (optional)</label>
                <input type="date" name="file_date" class="form-control" value="{{ old('file_date') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Sort order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" @selected(old('status')==='draft')>Draft</option>
                    <option value="published" @selected(old('status', 'published')==='published')>Published</option>
                </select>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
