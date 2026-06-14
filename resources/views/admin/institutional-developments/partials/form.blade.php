@php
    $item = $item ?? null;
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $item?->title) }}" required>
        @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" min="0" max="65535" class="form-control" value="{{ old('sort_order', $item?->sort_order ?? 0) }}">
        @error('sort_order')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="6" placeholder="Summary shown on the public Institutional Development & Capacity Building table...">{{ old('description', $item?->description) }}</textarea>
    @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Document file</label>
        <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx,.zip">
        <div class="form-text">PDF, Word, Excel, PowerPoint, CSV, or ZIP (max 50 MB).</div>
        @if ($item?->document_path)
            <div class="alert alert-light border mt-2 mb-0 py-2 small">
                <strong>Current:</strong> {{ $item->document_original_name ?: basename($item->document_path) }}
                <span class="badge text-bg-secondary ms-1">{{ $item->documentTypeLabel() }}</span>
                <div class="text-muted mt-1">Upload a new file to replace it.</div>
            </div>
        @endif
        @error('document')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Document date</label>
        <input type="date" name="document_date" class="form-control" value="{{ old('document_date', $item?->document_date?->format('Y-m-d')) }}">
        @error('document_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Images</label>
    @if ($item && count($item->images ?? []) > 0)
        <div class="irdc-admin-safeguard-existing-images mb-3">
            @foreach ($item->images as $imagePath)
                <label class="irdc-admin-safeguard-existing-images__item">
                    <input type="checkbox" name="remove_images[]" value="{{ $imagePath }}">
                    <img src="{{ asset('storage/'.$imagePath) }}" alt="">
                    <span>Remove</span>
                </label>
            @endforeach
        </div>
        <div class="form-text mb-2">Tick images to remove, then upload new ones below.</div>
    @endif

    <div class="irdc-admin-image-uploader" data-image-uploader>
        <div class="irdc-admin-image-uploader__head">
            <div class="form-text mb-0">JPG, PNG, or WebP (max 5 MB each, up to 12 images).</div>
            <button type="button" class="btn btn-sm btn-outline-success" data-add-image>+ Add image</button>
        </div>
        <div class="irdc-admin-image-uploader__list mt-2" data-image-list>
            <div class="irdc-admin-image-uploader__row" data-image-row>
                <span class="irdc-admin-image-uploader__number" data-image-number>1</span>
                <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp" data-image-input>
                <button type="button" class="btn btn-sm btn-outline-danger" data-remove-image disabled>Remove</button>
                <div class="irdc-admin-image-uploader__preview" data-image-preview></div>
            </div>
        </div>
    </div>
    @error('images')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    @error('images.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="published" @selected(old('status', $item?->status ?? 'published') === 'published')>Published</option>
        <option value="draft" @selected(old('status', $item?->status) === 'draft')>Draft</option>
    </select>
    @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<script>
document.querySelectorAll('[data-image-uploader]').forEach((uploader) => {
    const list = uploader.querySelector('[data-image-list]');
    const addButton = uploader.querySelector('[data-add-image]');

    const refreshRows = () => {
        const rows = list.querySelectorAll('[data-image-row]');
        rows.forEach((row, index) => {
            row.querySelector('[data-image-number]').textContent = index + 1;
            row.querySelector('[data-remove-image]').disabled = rows.length === 1;
        });
    };

    const bindRow = (row) => {
        const input = row.querySelector('[data-image-input]');
        const preview = row.querySelector('[data-image-preview]');
        const removeButton = row.querySelector('[data-remove-image]');

        input.addEventListener('change', () => {
            preview.innerHTML = '';
            const file = input.files && input.files[0];
            if (! file) {
                return;
            }

            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = '';
            image.onload = () => URL.revokeObjectURL(image.src);
            preview.appendChild(image);
        });

        removeButton.addEventListener('click', () => {
            row.remove();
            refreshRows();
        });
    };

    bindRow(list.querySelector('[data-image-row]'));

    addButton.addEventListener('click', () => {
        const row = list.querySelector('[data-image-row]').cloneNode(true);
        row.querySelector('[data-image-input]').value = '';
        row.querySelector('[data-image-preview]').innerHTML = '';
        list.appendChild(row);
        bindRow(row);
        refreshRows();
    });

    refreshRows();
});
</script>
