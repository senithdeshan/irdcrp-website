@extends('layouts.app')

@section('content')

<section class="hero-section text-white">
    <div class="container">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold">
                Integrated Rurban Development and Climate Resilience Project
            </h1>

            <p class="lead mt-4">
                Strengthening climate resilience, rural livelihoods, agriculture and livestock-based
                economic development through inclusive and sustainable interventions.
            </p>

            <div class="mt-4">
                <a href="/about" class="btn btn-light btn-lg rounded-pill px-4">Learn More</a>
                <a href="/procurement" class="btn btn-outline-light btn-lg rounded-pill px-4 ms-2">Procurement</a>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Project at a Glance</h2>
        <p class="section-subtitle">
            Key highlights of IRDCRP implementation, coverage and development focus.
        </p>
    </div>

    <div class="row text-center g-4">
        <div class="col-md-3">
            <div class="card feature-card p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p class="mb-0">Districts</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card feature-card p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p class="mb-0">Beneficiaries</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card feature-card p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p class="mb-0">Components</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card feature-card p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p class="mb-0">Project Period</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background:#F7FAFC;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Focus Areas</h2>
            <p class="section-subtitle">
                IRDCRP focuses on resilient development, sustainable agriculture,
                livestock improvement and inclusive rural transformation.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card feature-card p-4">
                    <div class="icon-circle">🌱</div>
                    <h5 class="fw-bold">Climate Resilience</h5>
                    <p>Improving community adaptation to climate risks and natural resource challenges.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card feature-card p-4">
                    <div class="icon-circle">🚜</div>
                    <h5 class="fw-bold">Agriculture</h5>
                    <p>Supporting productive, market-oriented and sustainable farming systems.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card feature-card p-4">
                    <div class="icon-circle">🐄</div>
                    <h5 class="fw-bold">Livestock</h5>
                    <p>Enhancing livestock-based livelihoods, productivity and value chains.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card feature-card p-4">
                    <div class="icon-circle">🤝</div>
                    <h5 class="fw-bold">Community Development</h5>
                    <p>Promoting inclusive development and stronger rural-urban linkages.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection