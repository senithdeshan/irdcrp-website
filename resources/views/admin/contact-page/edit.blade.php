@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Contact page</h1>
            <p class="text-muted mb-0">Edit emails, phone, fax, website, address, map location, and the contact form heading on the public Contact Us page.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/contact') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">View page</a>
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.contact-page.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Contact details</h2>

            <div class="mb-3">
                <label class="form-label">Email addresses</label>
                <textarea
                    name="emails_raw"
                    class="form-control"
                    rows="4"
                    required
                    placeholder="One email per line"
                >{{ old('emails_raw', implode("\n", $contact['emails'] ?? [])) }}</textarea>
                <div class="form-text">Enter one email address per line. All lines appear on the Contact page.</div>
                @error('emails_raw')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $contact['phone'] ?? '') }}" required>
                    @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fax</label>
                    <input type="text" name="fax" class="form-control" value="{{ old('fax', $contact['fax'] ?? '') }}">
                    @error('fax')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Website label</label>
                    <input type="text" name="website_label" class="form-control" value="{{ old('website_label', $contact['website_label'] ?? '') }}" required>
                    @error('website_label')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Website URL</label>
                    <input type="url" name="website_url" class="form-control" value="{{ old('website_url', $contact['website_url'] ?? '') }}" required>
                    @error('website_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Postal address</label>
                    <textarea name="address" class="form-control" rows="2" required>{{ old('address', $contact['address'] ?? '') }}</textarea>
                    @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Location &amp; map</h2>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Location heading</label>
                    <input type="text" name="location_title" class="form-control" value="{{ old('location_title', $contact['location']['title'] ?? '') }}" required>
                    @error('location_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Unit name</label>
                    <input type="text" name="location_unit" class="form-control" value="{{ old('location_unit', $contact['location']['unit'] ?? '') }}" required>
                    @error('location_unit')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Project line</label>
                    <input type="text" name="location_project" class="form-control" value="{{ old('location_project', $contact['location']['project'] ?? '') }}" required>
                    @error('location_project')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Place name (map / image alt text)</label>
                    <input type="text" name="location_place_name" class="form-control" value="{{ old('location_place_name', $contact['location']['place_name'] ?? '') }}" required>
                    @error('location_place_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="location_latitude" class="form-control" value="{{ old('location_latitude', $contact['location']['latitude'] ?? '') }}" required>
                    @error('location_latitude')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="location_longitude" class="form-control" value="{{ old('location_longitude', $contact['location']['longitude'] ?? '') }}" required>
                    @error('location_longitude')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Map zoom (1–21)</label>
                    <input type="number" name="location_map_zoom" class="form-control" min="1" max="21" value="{{ old('location_map_zoom', $contact['location']['map_zoom'] ?? 19) }}" required>
                    @error('location_map_zoom')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Google Maps link</label>
                    <input type="url" name="location_maps_url" class="form-control" value="{{ old('location_maps_url', $contact['location']['maps_url'] ?? '') }}" placeholder="https://maps.app.goo.gl/...">
                    <div class="form-text">Used for the “Get Directions” button. Leave blank to use coordinates.</div>
                    @error('location_maps_url')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Entrance photo caption</label>
                    <input type="text" name="location_image_caption" class="form-control" value="{{ old('location_image_caption', $contact['location']['image_caption'] ?? '') }}">
                    @error('location_image_caption')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Entrance photo</label>
                    <input type="file" name="location_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <div class="form-text">Upload a new image to replace the current entrance photo.</div>
                    @error('location_image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                @if ($locationImageUrl)
                    <div class="col-md-6">
                        <label class="form-label d-block">Current photo</label>
                        <img src="{{ $locationImageUrl }}" alt="Current entrance photo" class="img-fluid rounded border" style="max-height: 180px;">
                    </div>
                @endif
            </div>
        </div>

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Contact form heading</h2>

            <div class="mb-3">
                <label class="form-label">Form title</label>
                <input type="text" name="form_title" class="form-control" value="{{ old('form_title', $contact['form_title'] ?? '') }}" required>
                @error('form_title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-0">
                <label class="form-label">Form subtitle</label>
                <input type="text" name="form_subtitle" class="form-control" value="{{ old('form_subtitle', $contact['form_subtitle'] ?? '') }}" required>
                @error('form_subtitle')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <button type="submit" class="btn btn-green">Save contact page</button>
    </form>
</section>
@endsection
