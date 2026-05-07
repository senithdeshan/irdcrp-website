@extends('layouts.app')

@section('content')
<section class="container py-5">
    <h1 class="section-title mb-2">Content management</h1>
    <p class="text-muted mb-4">
        Signed in as {{ auth()->user()->email }} · <a href="{{ url('/') }}">View site</a> ·
        <a href="{{ route('dashboard') }}">Account</a> ·
    </p>
    <form class="d-inline-block mb-4" method="POST" action="{{ route('logout') }}">@csrf
        <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">News</h2>
                <p class="text-muted small mb-3">Create and publish news & events.</p>
                <a href="{{ route('admin.news.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Gallery</h2>
                <p class="text-muted small mb-3">Upload and delete gallery images.</p>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Vacancies</h2>
                <p class="text-muted small mb-3">Job notices with PDF and deadlines.</p>
                <a href="{{ route('admin.vacancies.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Downloads</h2>
                <p class="text-muted small mb-3">Document library (PDF, Office, etc.).</p>
                <a href="{{ route('admin.downloads.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Pages</h2>
                <p class="text-muted small mb-3">Custom pages at <code class="small">/p/your-slug</code></p>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Key leaders</h2>
                <p class="text-muted small mb-3">Home page portraits, roles (EN/SI/TA), and organisations.</p>
                <a href="{{ route('admin.key-leaders.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Success stories</h2>
                <p class="text-muted small mb-3">Farmer testimonials for the home page slider.</p>
                <a href="{{ route('admin.success-stories.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">GRM complaints</h2>
                <p class="text-muted small mb-3">Track complaints, set status, and write answers.</p>
                <a href="{{ route('admin.grm-complaints.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
    </div>
</section>
@endsection
