@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add latest insight</h2>
    <div class="irdc-admin-form-card" style="max-width: 760px;">
        <form method="POST" action="{{ route('admin.latest-insights.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Field update">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Insight date</label>
                    <input type="date" name="insight_date" class="form-control" value="{{ old('insight_date') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" @selected(old('status', 'inactive') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', 'inactive') === 'inactive')>Inactive</option>
                    </select>
                    <p class="small text-muted mb-0 mt-1">Only active insights display on the home page.</p>
                </div>
                <div class="col-12">
                    <label class="form-label">Summary</label>
                    <textarea name="summary" class="form-control" rows="5" required>{{ old('summary') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Image upload</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-green">Save insight</button>
                <a href="{{ route('admin.latest-insights.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection
