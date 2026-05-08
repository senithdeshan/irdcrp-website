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
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Menu order</label>
                    <input type="number" name="nav_order" class="form-control" value="{{ old('nav_order', $page->nav_order ?? 0) }}" min="0" max="9999">
                    <div class="form-text">Lower number shows first in navbar.</div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="1" id="show_in_nav" name="show_in_nav" @checked(old('show_in_nav', (bool) ($page->show_in_nav ?? false)))>
                        <label class="form-check-label" for="show_in_nav">
                            Show this page in navbar
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
