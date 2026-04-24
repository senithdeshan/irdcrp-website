@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Project Components</h1>
        <p class="lead mb-0">Main implementation areas of IRDCRP</p>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Core Components</h2>
        <p class="section-subtitle">
            The project components will be updated based on the official project design document.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card feature-card p-4">
                <div class="icon-circle">🌱</div>
                <h4 class="fw-bold">Component 01</h4>
                <h6 class="text-success">Climate Resilience and Natural Resource Management</h6>
                <p>
                    Activities may include climate-smart planning, resilient infrastructure,
                    watershed management and community-based adaptation measures.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card feature-card p-4">
                <div class="icon-circle">🚜</div>
                <h4 class="fw-bold">Component 02</h4>
                <h6 class="text-success">Agriculture and Livestock Development</h6>
                <p>
                    Support for improved farming practices, livestock productivity, value chains,
                    technology adoption and market-oriented production.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card feature-card p-4">
                <div class="icon-circle">🤝</div>
                <h4 class="fw-bold">Component 03</h4>
                <h6 class="text-success">Community and Institutional Development</h6>
                <p>
                    Strengthening producer groups, community organizations, stakeholder coordination
                    and capacity-building mechanisms.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card feature-card p-4">
                <div class="icon-circle">📊</div>
                <h4 class="fw-bold">Component 04</h4>
                <h6 class="text-success">Project Management, Monitoring and Evaluation</h6>
                <p>
                    Coordination, reporting, procurement, financial management, safeguards,
                    communication and results monitoring.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection