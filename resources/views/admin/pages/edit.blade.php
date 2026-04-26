@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit page</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.pages.update', $page) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content (HTML allowed)</label>
                <textarea name="content" class="form-control font-monospace" rows="14" required>{{ old('content', $page->content) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" @selected(old('status', $page->status)==='draft')>Draft</option>
                    <option value="published" @selected(old('status', $page->status)==='published')>Published</option>
                </select>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
