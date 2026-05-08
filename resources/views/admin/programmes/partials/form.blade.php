@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $programme?->title) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" class="form-control" min="0" max="999" value="{{ old('sort_order', $programme?->sort_order ?? 0) }}" required>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $programme?->slug) }}" pattern="[a-z0-9]+(?:-[a-z0-9]+)*">
    <div class="form-text">Leave empty to generate from title.</div>
</div>

<div class="mb-3">
    <label class="form-label">Summary</label>
    <textarea name="summary" class="form-control" rows="3">{{ old('summary', $programme?->summary) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="8">{{ old('description', $programme?->description) }}</textarea>
</div>

@if($programme?->image)
    <div class="mb-3">
        <label class="form-label">Current image</label>
        <div><img src="{{ str_starts_with($programme->image, 'images/') ? asset($programme->image) : asset('storage/'.$programme->image) }}" alt="" class="rounded" style="max-width: 240px; max-height: 150px; object-fit: cover;"></div>
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-8">
        <label class="form-label">{{ $programme ? 'Replace image' : 'Image' }}</label>
        <input type="file" name="image" class="form-control" accept="image/*" @required(! $programme)>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="published" @selected(old('status', $programme?->status ?? 'published') === 'published')>Published</option>
            <option value="draft" @selected(old('status', $programme?->status) === 'draft')>Draft</option>
        </select>
    </div>
</div>
