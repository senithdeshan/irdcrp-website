@extends('layouts.app')
@section('content')
<section class="container py-5">
    <h2 class="section-title mb-4">Add key leader</h2>
    <div class="card feature-card p-4" style="max-width: 640px;">
        <form method="POST" action="{{ route('admin.key-leaders.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Sort order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Group</label>
                    <select name="group" class="form-select" required>
                        <option value="key_leader" @selected(old('group', 'key_leader') === 'key_leader')>Key Leaders</option>
                        <option value="project_staff" @selected(old('group') === 'project_staff')>Project Staff</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Visible on home page</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Portrait photo <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp" required>
                </div>
                <div class="col-12"><hr class="my-1"></div>
                <div class="col-12">
                    <label class="form-label">Role — English <span class="text-danger">*</span></label>
                    <input type="text" name="role_en" class="form-control" value="{{ old('role_en') }}" required maxlength="255">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role — Sinhala</label>
                    <input type="text" name="role_si" class="form-control" value="{{ old('role_si') }}" maxlength="255">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role — Tamil</label>
                    <input type="text" name="role_ta" class="form-control" value="{{ old('role_ta') }}" maxlength="255">
                </div>
                <div class="col-12">
                    <label class="form-label">Organisation — English <span class="text-danger">*</span></label>
                    <textarea name="org_en" class="form-control" rows="2" required maxlength="2000">{{ old('org_en') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Organisation — Sinhala</label>
                    <textarea name="org_si" class="form-control" rows="2" maxlength="2000">{{ old('org_si') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Organisation — Tamil</label>
                    <textarea name="org_ta" class="form-control" rows="2" maxlength="2000">{{ old('org_ta') }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-green">Save</button>
                <a href="{{ route('admin.key-leaders.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection
