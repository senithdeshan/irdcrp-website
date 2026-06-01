<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" min="0" max="9999" class="form-control" value="{{ old('sort_order', $faq?->sort_order ?? 0) }}">
        @error('sort_order')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-9">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="published" @selected(old('status', $faq?->status ?? 'published') === 'published')>Published</option>
            <option value="draft" @selected(old('status', $faq?->status) === 'draft')>Draft</option>
        </select>
        @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Question</label>
    <input type="text" name="question" class="form-control" value="{{ old('question', $faq?->question) }}" required>
    @error('question')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Answer</label>
    <textarea name="answer" class="form-control" rows="8" required>{{ old('answer', $faq?->answer) }}</textarea>
    @error('answer')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>
