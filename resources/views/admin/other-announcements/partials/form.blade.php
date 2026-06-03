@php
    $item = $item ?? null;
@endphp

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" min="0" max="65535" class="form-control" value="{{ old('sort_order', $item?->sort_order ?? 0) }}">
        @error('sort_order')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-5">
        <label class="form-label">Published date</label>
        <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $item?->published_date?->format('Y-m-d')) }}">
        @error('published_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="published" @selected(old('status', $item?->status ?? 'published') === 'published')>Published</option>
            <option value="draft" @selected(old('status', $item?->status) === 'draft')>Draft</option>
        </select>
        @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $item?->title) }}" required>
    @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="8" required>{{ old('description', $item?->description) }}</textarea>
    @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Attachment (optional)</label>
    <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx,.zip">
    <div class="form-text">PDF, Word, Excel, PowerPoint, CSV, or ZIP (max 50 MB).</div>
    @if ($item?->document_path)
        <div class="alert alert-light border mt-2 mb-0 py-2 small">
            <strong>Current:</strong> {{ $item->document_original_name ?: basename($item->document_path) }}
            <span class="badge text-bg-secondary ms-1">{{ $item->documentTypeLabel() }}</span>
        </div>
    @endif
    @error('document')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
