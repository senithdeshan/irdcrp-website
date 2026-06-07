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
            <label class="form-label">District name (English)</label>
            <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $district?->name_en) }}" required maxlength="255">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sort order</label>
            <input type="number" name="sort_order" class="form-control" min="0" max="999" value="{{ old('sort_order', $district?->sort_order ?? 0) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Name (Sinhala)</label>
            <input type="text" name="name_si" class="form-control" value="{{ old('name_si', $district?->name_si) }}" maxlength="255">
        </div>
        <div class="col-md-6">
            <label class="form-label">Name (Tamil)</label>
            <input type="text" name="name_ta" class="form-control" value="{{ old('name_ta', $district?->name_ta) }}" maxlength="255">
        </div>
        <div class="col-md-6">
            <label class="form-label">Latitude</label>
            <input type="number" name="latitude" class="form-control" step="0.000001" min="-90" max="90" value="{{ old('latitude', $district?->latitude) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Longitude</label>
            <input type="number" name="longitude" class="form-control" step="0.000001" min="-180" max="180" value="{{ old('longitude', $district?->longitude) }}" required>
            <p class="small text-muted mb-0 mt-1">Used for Open-Meteo weather forecasts. Find coordinates on Google Maps.</p>
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            @php($activeOld = old('is_active', (int) ($district?->is_active ?? true)))
            <select name="is_active" class="form-select" required>
                <option value="1" @selected((string) $activeOld === '1')>Active</option>
                <option value="0" @selected((string) $activeOld === '0')>Hidden</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">District image {{ $district ? '(replace optional)' : '(optional)' }}</label>
            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
            <p class="small text-muted mb-0 mt-1">When set, this photo shows when visitors select this district. Otherwise the main section image is used.</p>
            @if($district?->imageUrl())
                <img src="{{ $district->imageUrl() }}" alt="" class="mt-3 rounded border" style="max-height: 160px; object-fit: cover;">
            @endif
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-green">Save district</button>
        <a href="{{ route('admin.weather-districts.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
