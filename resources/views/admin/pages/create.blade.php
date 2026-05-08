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
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Menu order</label>
                    <input type="number" name="nav_order" class="form-control" value="{{ old('nav_order', 0) }}" min="0" max="9999">
                    <div class="form-text">Lower number shows first in navbar.</div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="1" id="show_in_nav" name="show_in_nav" @checked(old('show_in_nav', 1))>
                        <label class="form-check-label" for="show_in_nav">
                            Show this page in navbar
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
