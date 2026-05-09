@php($item = $item ?? null)
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Card title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $item->title ?? '') }}" maxlength="120" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0" max="9999" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Status</label>
        @php($activeOld = old('is_active', isset($item) ? (int) $item->is_active : 1))
        <select name="is_active" class="form-select" required>
            <option value="1" @selected((string) $activeOld === '1')>Active</option>
            <option value="0" @selected((string) $activeOld === '0')>Inactive</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Bullet line 1</label>
        <input type="text" name="bullet_one" class="form-control" value="{{ old('bullet_one', $item->bullet_one ?? 'On-the-ground activities and good agricultural practices in partner areas.') }}" maxlength="255">
    </div>
    <div class="col-12">
        <label class="form-label">Bullet line 2</label>
        <input type="text" name="bullet_two" class="form-control" value="{{ old('bullet_two', $item->bullet_two ?? 'Highlights of training, workshops, and engagement with communities.') }}" maxlength="255">
    </div>
    <div class="col-12">
        <label class="form-label">Bullet line 3</label>
        <input type="text" name="bullet_three" class="form-control" value="{{ old('bullet_three', $item->bullet_three ?? 'New videos are added on the YouTube channel as they are ready.') }}" maxlength="255">
    </div>
    <div class="col-12">
        <label class="form-label">YouTube URL</label>
        <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $item->youtube_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=..." required>
        <p class="small text-muted mt-2 mb-0">Accepted formats: youtube.com/watch?v=..., youtu.be/..., youtube.com/embed/..., youtube.com/shorts/...</p>
    </div>
</div>

