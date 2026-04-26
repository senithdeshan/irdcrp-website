@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit vacancy</h2>
    <div class="card feature-card p-4">
        <p class="small text-muted">Current file: <a target="_blank" href="{{ asset('storage/'.$vacancy->pdf_path) }}">View PDF</a></p>
        <form method="POST" action="{{ route('admin.vacancies.update', $vacancy) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $vacancy->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="6" required>{{ old('description', $vacancy->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Replace PDF (optional)</label>
                <input type="file" name="pdf" class="form-control" accept="application/pdf">
            </div>
            <div class="mb-3">
                <label class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $vacancy->deadline->format('Y-m-d')) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" @selected(old('status', $vacancy->status)==='draft')>Draft</option>
                    <option value="open" @selected(old('status', $vacancy->status)==='open')>Open</option>
                    <option value="closed" @selected(old('status', $vacancy->status)==='closed')>Closed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.vacancies.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
