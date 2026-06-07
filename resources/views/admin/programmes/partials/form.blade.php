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
    <label class="form-label">Main description</label>
    <textarea name="description" class="form-control" rows="6" placeholder="Intro text shown before the content blocks below…">{{ old('description', $programme?->description) }}</textarea>
    <div class="form-text">Use content blocks below to add more text, images, and tables after this intro.</div>
</div>

@include('admin.programmes.partials.content-blocks', ['programme' => $programme ?? null])

<div class="irdc-admin-programme-cover mb-4">
    <label class="form-label">Cover image</label>
    <div class="form-text mb-2">This image is used on programme cards and at the top of the programme page.</div>

    @if($programme?->image)
        <div class="mb-3">
            <div class="irdc-admin-programme-cover__preview">
                <img src="{{ $programme->coverImageUrl() }}" alt="Current cover image" class="rounded">
            </div>
        </div>
    @endif

    <input type="file" name="image" class="form-control" accept="image/*" @required(! $programme)>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-12">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="published" @selected(old('status', $programme?->status ?? 'published') === 'published')>Published</option>
            <option value="draft" @selected(old('status', $programme?->status) === 'draft')>Draft</option>
        </select>
        <div class="form-text">Published programmes appear automatically in the main navigation Programmes dropdown.</div>
    </div>
</div>
