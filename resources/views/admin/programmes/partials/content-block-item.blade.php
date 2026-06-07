@php
    $type = $block['type'] ?? 'text';
@endphp

<div class="irdc-admin-programme-block card feature-card p-3" data-block-item data-block-type="{{ $type }}">
    <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-bg-light border text-uppercase">{{ $type }}</span>
            <span class="small text-muted">Block <span data-block-number>{{ (int) $index + 1 }}</span></span>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger" data-remove-block>Remove</button>
    </div>

    <input type="hidden" name="blocks[{{ $index }}][type]" value="{{ $type }}">

    @if ($type === 'text')
        <label class="form-label">Text section</label>
        <textarea name="blocks[{{ $index }}][body]" class="form-control" rows="5" placeholder="Write programme details for this section…">{{ old("blocks.$index.body", $block['body'] ?? '') }}</textarea>
    @elseif ($type === 'image')
        <div class="row g-3">
            <div class="col-md-7">
                <label class="form-label">Image</label>
                <input type="file" name="blocks[{{ $index }}][image]" class="form-control" accept="image/*" data-block-file>
                @if (filled($block['path'] ?? null))
                    <input type="hidden" name="blocks[{{ $index }}][existing_path]" value="{{ $block['path'] }}">
                    <div class="mt-2">
                        <img src="{{ ($programme ?? new \App\Models\Programme())->storageImageUrl($block['path']) }}" alt="" class="rounded" style="max-width:220px; max-height:150px; object-fit:cover;">
                    </div>
                @endif
            </div>
            <div class="col-md-5">
                <label class="form-label">Caption (optional)</label>
                <input type="text" name="blocks[{{ $index }}][caption]" class="form-control" value="{{ old("blocks.$index.caption", $block['caption'] ?? '') }}">
            </div>
        </div>
    @elseif ($type === 'table')
        <div class="mb-3">
            <label class="form-label">Table title (optional)</label>
            <input type="text" name="blocks[{{ $index }}][title]" class="form-control" value="{{ old("blocks.$index.title", $block['title'] ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Column headers</label>
            <input type="text" name="blocks[{{ $index }}][headers_text]" class="form-control" value="{{ old("blocks.$index.headers_text", $block['headers_text'] ?? implode('|', $block['headers'] ?? [])) }}" placeholder="Column 1|Column 2|Column 3">
            <div class="form-text">Separate columns with <code>|</code></div>
        </div>
        <div>
            <label class="form-label">Rows</label>
            <textarea name="blocks[{{ $index }}][rows_text]" class="form-control" rows="5" placeholder="Row 1 col 1|Row 1 col 2&#10;Row 2 col 1|Row 2 col 2">{{ old("blocks.$index.rows_text", $block['rows_text'] ?? collect($block['rows'] ?? [])->map(fn ($row) => implode('|', $row))->implode("\n")) }}</textarea>
            <div class="form-text">One row per line. Separate cells with <code>|</code></div>
        </div>
    @endif
</div>
