@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Organizational Structure</h1>
            <p class="text-muted mb-0">Update the governance chart and the Project Staff fallback image on the public Organizational Structure page.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('organizational-structure') }}" target="_blank" class="btn btn-outline-secondary">View page</a>
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the details.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="irdc-admin-form-card" style="max-width: 920px;">
        <form method="POST" action="{{ route('admin.organizational-structure.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="section-title" class="form-label">Section title</label>
                    <input id="section-title" type="text" name="section_title" class="form-control" value="{{ old('section_title', $structure['section_title'] ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="image-alt" class="form-label">Image alt text</label>
                    <input id="image-alt" type="text" name="image_alt" class="form-control" value="{{ old('image_alt', $structure['image_alt'] ?? '') }}">
                </div>

                <div class="col-12">
                    <label for="section-subtitle" class="form-label">Section subtitle</label>
                    <textarea id="section-subtitle" name="section_subtitle" rows="3" class="form-control">{{ old('section_subtitle', $structure['section_subtitle'] ?? '') }}</textarea>
                </div>

                <div class="col-12">
                    <label for="structure-image" class="form-label">Structure image</label>
                    <input id="structure-image" type="file" name="structure_image" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Upload JPG, PNG, or WebP. Recommended: clear, high-resolution image.</div>
                </div>

                @if(app(\App\Support\SiteSettings::class)->organizationalStructureImageUrl($structure['image'] ?? null))
                    <div class="col-12">
                        <p class="form-label mb-2">Current governance chart</p>
                        <div class="rounded border bg-white p-3">
                            <img src="{{ app(\App\Support\SiteSettings::class)->organizationalStructureImageUrl($structure['image']) }}" alt="{{ $structure['image_alt'] ?? 'Organizational structure' }}" class="img-fluid d-block mx-auto" style="max-height: 520px; object-fit: contain;">
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_structure_image" value="1" id="remove-structure-image">
                            <label class="form-check-label text-danger" for="remove-structure-image">Delete current governance chart</label>
                        </div>
                    </div>
                @endif

                <div class="col-12">
                    <hr class="my-2">
                    <h2 class="h5 fw-bold mb-1">Project Staff fallback image</h2>
                    <p class="text-muted small mb-3">Shown below the Project Staff section. If no staff profiles are published, this image appears on its own instead of the empty placeholder.</p>
                </div>

                <div class="col-md-6">
                    <label for="staff-fallback-image-alt" class="form-label">Fallback image alt text</label>
                    <input id="staff-fallback-image-alt" type="text" name="staff_fallback_image_alt" class="form-control" value="{{ old('staff_fallback_image_alt', $structure['staff_fallback_image_alt'] ?? '') }}">
                </div>

                <div class="col-md-6">
                    <label for="staff-fallback-image" class="form-label">Fallback image</label>
                    <input id="staff-fallback-image" type="file" name="staff_fallback_image" class="form-control" accept="image/png,image/jpeg,image/webp">
                </div>

                @if(app(\App\Support\SiteSettings::class)->organizationalStructureImageUrl($structure['staff_fallback_image'] ?? null))
                    <div class="col-12">
                        <p class="form-label mb-2">Current fallback image</p>
                        <div class="rounded border bg-white p-3">
                            <img src="{{ app(\App\Support\SiteSettings::class)->organizationalStructureImageUrl($structure['staff_fallback_image']) }}" alt="{{ $structure['staff_fallback_image_alt'] ?? 'Project staff' }}" class="img-fluid d-block mx-auto" style="max-height: 420px; object-fit: contain;">
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_staff_fallback_image" value="1" id="remove-staff-fallback-image">
                            <label class="form-check-label text-danger" for="remove-staff-fallback-image">Delete current fallback image</label>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-green">Save changes</button>
                <a href="{{ route('admin.key-leaders.index') }}" class="btn btn-outline-secondary">Manage project staff</a>
            </div>
        </form>
    </div>
</section>
@endsection
