@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add vacancy</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.vacancies.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">PDF (max 15 MB)</label>
                <input type="file" name="pdf" class="form-control" accept="application/pdf" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Application deadline</label>
                <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" @selected(old('status')==='draft')>Draft (hidden from public)</option>
                    <option value="open" @selected(old('status', 'open')==='open')>Open</option>
                    <option value="closed" @selected(old('status')==='closed')>Closed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.vacancies.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection
