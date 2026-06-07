@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Home popup</h1>
            <p class="text-muted mb-0">Upload an announcement image and turn it on when something important needs to appear as visitors enter the website.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.home-popup.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card feature-card p-4 h-100">
                    <h2 class="h5 fw-bold mb-3">Popup image</h2>

                    <div class="mb-3">
                        <label for="popup-image" class="form-label">Upload image</label>
                        <input
                            id="popup-image"
                            type="file"
                            name="image"
                            class="form-control"
                            accept="image/png,image/jpeg,image/webp"
                        >
                        <div class="form-text">Recommended: wide banner (1200×675 or similar). JPG, PNG, or WebP up to 8 MB.</div>
                    </div>

                    <div class="mb-3">
                        <label for="popup-alt" class="form-label">Image description (accessibility)</label>
                        <input
                            id="popup-alt"
                            type="text"
                            name="alt"
                            class="form-control"
                            value="{{ old('alt', $popup['alt'] ?? 'Important announcement') }}"
                            placeholder="Important announcement"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="popup-link" class="form-label">Optional link URL</label>
                        <input
                            id="popup-link"
                            type="url"
                            name="link_url"
                            class="form-control"
                            value="{{ old('link_url', $popup['link_url'] ?? '') }}"
                            placeholder="https://..."
                        >
                        <div class="form-text">If set, clicking the image opens this page in a new tab.</div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="popup-enabled"
                            name="enabled"
                            value="1"
                            @checked(old('enabled', $popup['enabled'] ?? false))
                        >
                        <label class="form-check-label fw-semibold" for="popup-enabled">Show popup on website entry</label>
                    </div>

                    @if(filled($popup['image'] ?? null))
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="remove-image" name="remove_image" value="1">
                            <label class="form-check-label text-danger" for="remove-image">Remove current image</label>
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-green">Save popup</button>
                        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary">Preview on home page</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card feature-card p-4 h-100">
                    <h2 class="h5 fw-bold mb-3">Preview</h2>

                    @if(filled($popup['image'] ?? null))
                        <div class="irdc-home-popup-preview">
                            <img
                                src="{{ app(\App\Support\SiteSettings::class)->homePopupImageUrl($popup['image']) }}"
                                alt="{{ $popup['alt'] ?? 'Important announcement' }}"
                                class="img-fluid rounded border"
                            >
                        </div>
                        <p class="small text-muted mt-3 mb-0">
                            Status:
                            @if($popup['enabled'] ?? false)
                                <span class="badge text-bg-success">Active — visitors will see this popup</span>
                            @else
                                <span class="badge text-bg-secondary">Inactive — saved but hidden</span>
                            @endif
                        </p>
                    @else
                        <div class="rounded border bg-light p-4 text-center text-muted">
                            <p class="mb-2">No popup image uploaded yet.</p>
                            <p class="small mb-0">Upload a banner to preview it here.</p>
                        </div>
                    @endif

                    <hr class="my-4">

                    <p class="small text-muted mb-2"><strong>Sample banner</strong> — you can upload this as a starting point:</p>
                    @if(file_exists(public_path('images/home-popup/home-popup-sample.png')))
                        <img src="{{ asset('images/home-popup/home-popup-sample.png') }}" alt="Sample home popup banner" class="img-fluid rounded border mb-2">
                        <p class="small text-muted mb-0">Save this image from your browser, then upload it above and activate the popup.</p>
                    @endif
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
