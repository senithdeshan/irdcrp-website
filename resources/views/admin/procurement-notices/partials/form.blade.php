@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Reference no.</label>
        <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no', $notice?->reference_no) }}" placeholder="IRDCRP/PROC/001">
    </div>
    <div class="col-md-4">
        <label class="form-label">Type</label>
        <select name="notice_type" class="form-select" required>
            @foreach(['notice' => 'Notice', 'bidding' => 'Bidding document', 'award' => 'Award information', 'report' => 'Report', 'other' => 'Other'] as $value => $label)
                <option value="{{ $value }}" @selected(old('notice_type', $notice?->notice_type ?? 'notice') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach(['draft' => 'Draft', 'open' => 'Open', 'closed' => 'Closed'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $notice?->status ?? 'open') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $notice?->title) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $notice?->description) }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Published date</label>
        <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $notice?->published_date?->format('Y-m-d')) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Closing date</label>
        <input type="date" name="closing_date" class="form-control" value="{{ old('closing_date', $notice?->closing_date?->format('Y-m-d')) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $notice?->sort_order ?? 0) }}" min="0">
    </div>
</div>

@if($notice && count($notice->documents ?? []) > 0)
    <hr class="my-4">
    <h3 class="h6 fw-bold mb-3">Current PDFs</h3>
    <div class="row g-3">
        @foreach($notice->documents ?? [] as $index => $document)
            <div class="col-md-6">
                <div class="border rounded p-3 h-100">
                    <div class="fw-semibold">{{ $document['label'] ?? 'Procurement PDF' }}</div>
                    <a class="small" href="{{ asset('storage/'.($document['path'] ?? '')) }}" target="_blank" rel="noopener">
                        {{ $document['original_name'] ?? basename($document['path'] ?? '') }}
                    </a>
                    <label class="form-check mt-2 mb-0">
                        <input class="form-check-input" type="checkbox" name="remove_documents[]" value="{{ $index }}">
                        <span class="form-check-label text-danger">Remove this PDF</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
@endif

<hr class="my-4">
<h3 class="h6 fw-bold mb-3">Add PDF attachments</h3>
<p class="text-muted small">Upload the main procurement PDF and optional report PDFs. You can add up to 6 files per notice.</p>

@for($i = 0; $i < 3; $i++)
    <div class="row g-3 align-items-end mb-3">
        <div class="col-md-5">
            <label class="form-label">PDF label {{ $i + 1 }}</label>
            <input type="text" name="document_labels[]" class="form-control" value="{{ old('document_labels.'.$i) }}" placeholder="{{ $i === 0 ? 'Main procurement notice' : 'Supporting report '.($i + 1) }}">
        </div>
        <div class="col-md-7">
            <label class="form-label">PDF file {{ $i + 1 }}</label>
            <input type="file" name="documents[]" class="form-control" accept="application/pdf,.pdf">
        </div>
    </div>
@endfor

<div class="d-flex gap-2 pt-3">
    <button type="submit" class="btn btn-green">Save</button>
    <a href="{{ route('admin.procurement-notices.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
