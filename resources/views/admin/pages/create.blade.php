@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add page</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.pages.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug (optional, e.g. <code>procurement-faq</code>)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" title="lowercase, numbers, hyphens">
                <div class="form-text">If empty, a slug is generated from the title.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Content (HTML allowed)</label>
                <textarea name="content" class="form-control font-monospace" rows="14" required>{{ old('content') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" @selected(old('status')==='draft')>Draft</option>
                    <option value="published" @selected(old('status', 'published')==='published')>Published</option>
                </select>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
