@php
    $cercDocument = $cercDocument ?? null;
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $cercDocument?->title) }}" required>
        @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" min="0" max="65535" class="form-control" value="{{ old('sort_order', $cercDocument?->sort_order ?? 0) }}">
        @error('sort_order')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="6" placeholder="Summary shown on the public CERC document table...">{{ old('description', $cercDocument?->description) }}</textarea>
    @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Document file</label>
        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx,.zip" @if(! $cercDocument) required @endif>
        <div class="form-text">PDF, Word, Excel, PowerPoint, CSV, or ZIP (max 50 MB).</div>
        @if ($cercDocument?->file_path)
            <div class="alert alert-light border mt-2 mb-0 py-2 small">
                <strong>Current:</strong> {{ $cercDocument->file_original_name ?: basename($cercDocument->file_path) }}
                <span class="badge text-bg-secondary ms-1">{{ $cercDocument->fileTypeLabel() }}</span>
                <div class="text-muted mt-1">Upload a new file to replace it.</div>
            </div>
        @endif
        @error('file')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Document date</label>
        <input type="date" name="file_date" class="form-control" value="{{ old('file_date', $cercDocument?->file_date?->format('Y-m-d')) }}">
        @error('file_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="published" @selected(old('status', $cercDocument?->status ?? 'published') === 'published')>Published</option>
        <option value="draft" @selected(old('status', $cercDocument?->status) === 'draft')>Draft</option>
    </select>
    @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
