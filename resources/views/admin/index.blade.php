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
                <h2 class="h5 fw-bold">Programmes</h2>
                <p class="text-muted small mb-3">Manage programme images, titles, descriptions, and nav dropdown items.</p>
                <a href="{{ route('admin.programmes.index') }}" class="btn btn-green btn-sm">Manage</a>
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
                <h2 class="h5 fw-bold">Procurement Notices</h2>
                <p class="text-muted small mb-3">Publish procurement notices with multiple attached PDF reports.</p>
                <a href="{{ route('admin.procurement-notices.index') }}" class="btn btn-green btn-sm">Manage</a>
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
                <h2 class="h5 fw-bold">Safeguard</h2>
                <p class="text-muted small mb-3">Add descriptions, reports, Office files, presentations, and images for Safeguard pages.</p>
                <a href="{{ route('admin.safeguards.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Other announcements</h2>
                <p class="text-muted small mb-3">General notices under Announcements → Other (not procurement or vacancy).</p>
                <a href="{{ route('admin.other-announcements.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">FAQs</h2>
                <p class="text-muted small mb-3">Edit public frequently asked questions and answers.</p>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">About Us</h2>
                <p class="text-muted small mb-3">Edit mission, objectives, grievance, and why choose us text on the About page.</p>
                <a href="{{ route('admin.about-page.edit') }}" class="btn btn-green btn-sm">Manage</a>
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
                <h2 class="h5 fw-bold">Project components</h2>
                <p class="text-muted small mb-3">Edit component titles, budgets, descriptions, order, and visibility.</p>
                <a href="{{ route('admin.project-components.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Impact metrics</h2>
                <p class="text-muted small mb-3">Edit home page numbers for districts, beneficiaries, investment, and projects.</p>
                <a href="{{ route('admin.impact-metrics.index') }}" class="btn btn-green btn-sm">Manage</a>
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
                <h2 class="h5 fw-bold">Latest insights</h2>
                <p class="text-muted small mb-3">Approved field insights for the home page slider.</p>
                <a href="{{ route('admin.latest-insights.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Home videos</h2>
                <p class="text-muted small mb-3">Manage Krushi TV, Field Stories, and Krushi Radio card video links.</p>
                <a href="{{ route('admin.home-videos.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Home images</h2>
                <p class="text-muted small mb-3">Upload and change the seven home page hero slider images.</p>
                <a href="{{ route('admin.home-images.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Site settings</h2>
                <p class="text-muted small mb-3">Edit footer logo, project contact details, and social channel links.</p>
                <a href="{{ route('admin.site-settings.edit') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">GRM complaints</h2>
                <p class="text-muted small mb-3">Track complaints, set status, and write answers.</p>
                <a href="{{ route('admin.grm-complaints.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card feature-card p-4 h-100">
                <h2 class="h5 fw-bold">Support messages</h2>
                <p class="text-muted small mb-3">Review contact form inquiries and record replies.</p>
                <a href="{{ route('admin.support-messages.index') }}" class="btn btn-green btn-sm">Manage</a>
            </div>
        </div>
    </div>
</section>
@endsection
