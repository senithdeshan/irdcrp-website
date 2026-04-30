@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Edit success story</h2>
    <div class="irdc-admin-form-card" style="max-width: 680px;">
        <div class="mb-3">
            <img src="{{ asset('storage/'.$successStory->photo) }}" alt="{{ $successStory->name }}" class="img-fluid rounded" style="max-height: 220px;">
        </div>
        <form method="POST" action="{{ route('admin.success-stories.update', $successStory) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Farmer name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $successStory->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $successStory->location) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Province</label>
                    <input type="text" name="province" class="form-control" value="{{ old('province', $successStory->province) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Rating</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="irdc-star-rating" role="radiogroup" aria-label="Story rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input
                                    type="radio"
                                    id="rating-edit-{{ $i }}"
                                    name="rating"
                                    value="{{ $i }}"
                                    @checked(old('rating', $successStory->rating) == $i)
                                    required
                                >
                                <label for="rating-edit-{{ $i }}" title="{{ $i }} star{{ $i > 1 ? 's' : '' }}">★</label>
                            @endfor
                        </div>
                        <span class="small text-muted">Click stars to rate</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" @selected(old('status', $successStory->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $successStory->status) === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Story / testimonial</label>
                    <textarea name="story" class="form-control" rows="4" required>{{ old('story', $successStory->story) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Replace photo (optional)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-green">Save changes</button>
                <a href="{{ route('admin.success-stories.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</section>
@endsection
