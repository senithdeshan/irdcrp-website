@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">News & Events</h1>
        <p class="lead mb-0">Latest updates, events and announcements of IRDCRP</p>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Latest News</h2>
        <p class="section-subtitle">
            Recent project updates, field activities, workshops and public announcements.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature-card">
                <div style="height:200px; background:#EAF7F0;" class="d-flex align-items-center justify-content-center">
                    <span class="fs-1">📰</span>
                </div>
                <div class="card-body p-4">
                    <small class="text-success fw-bold">News</small>
                    <h5 class="fw-bold mt-2">IRDCRP Project Launch Update</h5>
                    <p>
                        Initial project updates and activities will be published here after official approval.
                    </p>
                    <a href="#" class="btn btn-green btn-sm">Read More</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card feature-card">
                <div style="height:200px; background:#EAF7F0;" class="d-flex align-items-center justify-content-center">
                    <span class="fs-1">📅</span>
                </div>
                <div class="card-body p-4">
                    <small class="text-success fw-bold">Event</small>
                    <h5 class="fw-bold mt-2">Stakeholder Consultation Programme</h5>
                    <p>
                        Information on workshops, meetings and consultations will be updated in this section.
                    </p>
                    <a href="#" class="btn btn-green btn-sm">Read More</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card feature-card">
                <div style="height:200px; background:#EAF7F0;" class="d-flex align-items-center justify-content-center">
                    <span class="fs-1">🌱</span>
                </div>
                <div class="card-body p-4">
                    <small class="text-success fw-bold">Field Update</small>
                    <h5 class="fw-bold mt-2">Climate Resilience Field Activities</h5>
                    <p>
                        Field-level progress, success stories and implementation updates will be shared here.
                    </p>
                    <a href="#" class="btn btn-green btn-sm">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection