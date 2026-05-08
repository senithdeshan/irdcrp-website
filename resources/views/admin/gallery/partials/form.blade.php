@php
    $selectedCategory = old('category', $gallery?->category ?? 'photos');
    $selectedType = old('media_type', $gallery?->media_type ?? 'image');
@endphp

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
    <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category" class="form-select" required>
            @foreach($categories as $slug => $label)
                <option value="{{ $slug }}" @selected($selectedCategory === $slug)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Media type</label>
        <select name="media_type" class="form-select" required>
            @foreach($mediaTypes as $slug => $label)
                <option value="{{ $slug }}" @selected($selectedType === $slug)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $gallery?->title) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery?->description) }}</textarea>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Date</label>
        <input type="date" name="item_date" class="form-control" value="{{ old('item_date', $gallery?->item_date?->format('Y-m-d')) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="published" @selected(old('status', $gallery?->status ?? 'published') === 'published')>Published</option>
            <option value="draft" @selected(old('status', $gallery?->status) === 'draft')>Draft</option>
        </select>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">{{ $gallery ? 'Replace upload' : 'Upload file' }}</label>
    <input type="file" name="media_file" class="form-control" accept="image/*,audio/*,video/*,.pdf,.ppt,.pptx,.pps,.ppsx" @required(! $gallery)>
    <div class="form-text">Use images for Photos, audio files for Audio, video files for Videos/Voice, and PDF/PPT files for Presentation.</div>
</div>

<div class="mb-4">
    <label class="form-label">External URL</label>
    <input type="url" name="external_url" class="form-control" value="{{ old('external_url', $gallery?->external_url) }}" placeholder="https://youtube.com/... or https://example.com/file.pdf">
    <div class="form-text">Optional. Use this for YouTube videos, hosted audio, online presentations, or external media links.</div>
</div>
