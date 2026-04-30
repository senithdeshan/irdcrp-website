@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add success story</h2>
    <div class="card feature-card p-4" style="max-width: 680px;">
        <form method="POST" action="{{ route('admin.success-stories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Farmer name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Province</label>
                    <input type="text" name="province" class="form-control" value="{{ old('province') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select" required>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(old('rating', 5) == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Story / testimonial</label>
                    <textarea name="story" class="form-control" rows="4" required>{{ old('story') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Photo upload</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-green">Save story</button>
                <a href="{{ route('admin.success-stories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection
