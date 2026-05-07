@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit project component</h2>
    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.project-components.update', $projectComponent) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Component number</label>
                    <input type="number" name="component_number" min="1" max="99" class="form-control" value="{{ old('component_number', $projectComponent->component_number) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sort order</label>
                    <input type="number" name="sort_order" min="0" max="999" class="form-control" value="{{ old('sort_order', $projectComponent->sort_order) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="published" @selected(old('status', $projectComponent->status) === 'published')>Published</option>
                        <option value="draft" @selected(old('status', $projectComponent->status) === 'draft')>Draft</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $projectComponent->title) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Budget</label>
                <input type="text" name="budget" class="form-control" value="{{ old('budget', $projectComponent->budget) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Beneficiaries</label>
                <input type="text" name="beneficiaries" class="form-control" value="{{ old('beneficiaries', $projectComponent->beneficiaries) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="8" required>{{ old('description', $projectComponent->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-green">Save</button>
            <a href="{{ route('admin.project-components.index') }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
</section>
@endsection
