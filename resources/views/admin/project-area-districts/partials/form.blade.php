@php
    $district = $district ?? null;
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

<form method="POST" action="{{ $action }}">
    @csrf
    @if(($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label for="district" class="form-label">District</label>
        <input id="district" type="text" name="district" class="form-control" value="{{ old('district', $district->district ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="ds-divisions" class="form-label">DS Divisions</label>
        <textarea id="ds-divisions" name="ds_divisions" rows="3" class="form-control">{{ old('ds_divisions', $district->ds_divisions ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="focus" class="form-label">Main focus</label>
        <textarea id="focus" name="focus" rows="3" class="form-control">{{ old('focus', $district->focus ?? '') }}</textarea>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="sort-order" class="form-label">Sort order</label>
            <input id="sort-order" type="number" name="sort_order" min="0" max="9999" class="form-control" value="{{ old('sort_order', $district->sort_order ?? 0) }}" required>
            <div class="form-text">Lower numbers appear first.</div>
        </div>
        <div class="col-md-6">
            <label for="is-active" class="form-label">Status</label>
            <select id="is-active" name="is_active" class="form-select" required>
                <option value="1" @selected((string) old('is_active', $district->is_active ?? true) === '1')>Published</option>
                <option value="0" @selected((string) old('is_active', $district->is_active ?? true) === '0')>Hidden</option>
            </select>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <button type="submit" class="btn btn-green">Save district</button>
        <a href="{{ route('admin.project-areas.edit') }}" class="btn btn-outline-secondary">Back to project areas</a>
    </div>
</form>
