@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Downloads</h1>
        <p class="lead mb-0">Reports, guidelines, forms and official project documents</p>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Document Library</h2>
        <p class="section-subtitle">
            Important documents related to IRDCRP will be made available for public reference.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature-card p-4">
                <div class="icon-circle">📘</div>
                <h5 class="fw-bold">Project Documents</h5>
                <p>Project design documents, implementation manuals and official guidelines.</p>
                <a href="#" class="btn btn-green btn-sm">View Documents</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card feature-card p-4">
                <div class="icon-circle">📊</div>
                <h5 class="fw-bold">Reports</h5>
                <p>Progress reports, annual reports, monitoring reports and review documents.</p>
                <a href="#" class="btn btn-green btn-sm">View Reports</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card feature-card p-4">
                <div class="icon-circle">📝</div>
                <h5 class="fw-bold">Forms & Templates</h5>
                <p>Application forms, formats, templates and other public downloadable documents.</p>
                <a href="#" class="btn btn-green btn-sm">View Forms</a>
            </div>
        </div>
    </div>
</section>

@endsection