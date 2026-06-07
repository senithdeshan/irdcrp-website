@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Partner name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $partner?->name) }}" required maxlength="255">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sort order</label>
            <input type="number" name="sort_order" class="form-control" min="0" max="999" value="{{ old('sort_order', $partner?->sort_order ?? 0) }}" required>
        </div>
        <div class="col-12">
            <label class="form-label">Website URL</label>
            <input type="url" name="website_url" class="form-control" value="{{ old('website_url', $partner?->website_url) }}" placeholder="https://example.com">
            <p class="small text-muted mb-0 mt-1">Visitors go to this site when they click the partner logo on the home page.</p>
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            @php($activeOld = old('is_active', (int) ($partner?->is_active ?? true)))
            <select name="is_active" class="form-select" required>
                <option value="1" @selected((string) $activeOld === '1')>Active</option>
                <option value="0" @selected((string) $activeOld === '0')>Hidden</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Logo {{ $partner ? '(replace optional)' : '' }}</label>
            <input type="file" name="logo" class="form-control" accept="image/jpeg,image/png,image/webp,image/svg+xml" @required(! $partner)>
            <p class="small text-muted mb-0 mt-1">PNG or JPG with transparent background works best. Max 4 MB.</p>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-green">Save partner</button>
        <a href="{{ route('admin.project-partners.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
