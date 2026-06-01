@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Site settings</h1>
            <p class="text-muted mb-0">Update footer project details and public social media channel links.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
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

    <form method="POST" action="{{ route('admin.site-settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card feature-card p-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Footer column 1</h2>
            <p class="text-muted small mb-4">These details appear in the first footer column with the project logo and social icons.</p>

            <div class="row g-4">
                <div class="col-md-7">
                    <label for="footer-project-name" class="form-label">Project name</label>
                    <input
                        id="footer-project-name"
                        type="text"
                        name="footer[project_name]"
                        class="form-control"
                        value="{{ old('footer.project_name', $footerSettings['project_name'] ?? '') }}"
                        required
                    >
                </div>

                <div class="col-md-5">
                    <label for="footer-logo" class="form-label">Project logo</label>
                    <input
                        id="footer-logo"
                        type="file"
                        name="footer_logo"
                        class="form-control"
                        accept="image/png,image/jpeg,image/webp"
                    >
                    @if(!empty($footerSettings['logo']))
                        <div class="mt-3 d-flex align-items-center gap-3">
                            <img src="{{ asset($footerSettings['logo']) }}" alt="Current footer logo" class="rounded border bg-white p-1" style="height: 64px; width: auto;">
                            <span class="text-muted small">Current logo</span>
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <label for="footer-address" class="form-label">PMU address</label>
                    <textarea
                        id="footer-address"
                        name="footer[address]"
                        class="form-control"
                        rows="3"
                    >{{ old('footer.address', $footerSettings['address'] ?? '') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="footer-email" class="form-label">Email address</label>
                    <input
                        id="footer-email"
                        type="email"
                        name="footer[email]"
                        class="form-control"
                        value="{{ old('footer.email', $footerSettings['email'] ?? '') }}"
                        placeholder="info@example.lk"
                    >
                </div>

                <div class="col-md-6">
                    <label for="footer-phone" class="form-label">Contact number</label>
                    <input
                        id="footer-phone"
                        type="text"
                        name="footer[phone]"
                        class="form-control"
                        value="{{ old('footer.phone', $footerSettings['phone'] ?? '') }}"
                        placeholder="+94..."
                    >
                </div>
            </div>
        </div>

        <div class="card feature-card p-4">
            <h2 class="h5 fw-bold mb-3">Social channel links</h2>

            <div class="row g-4">
                @foreach($socialKeys as $key)
                    <div class="col-md-6">
                        <label for="social-{{ $key }}" class="form-label text-capitalize">{{ $key }}</label>
                        <input
                            id="social-{{ $key }}"
                            type="url"
                            name="social[{{ $key }}]"
                            class="form-control"
                            value="{{ old("social.$key", $socialLinks[$key] ?? '') }}"
                            placeholder="https://..."
                        >
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-green">Save social links</button>
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary">View home page</a>
            </div>
        </div>
    </form>
</section>
@endsection
