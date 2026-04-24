@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">About IRDCRP</h1>
        <p class="lead mb-0">Integrated Rurban Development and Climate Resilience Project</p>
    </div>
</section>

<section class="container py-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-6">
            <h2 class="section-title">Project Overview</h2>
            <p>
                The Integrated Rurban Development and Climate Resilience Project aims to strengthen
                climate-resilient development, improve livelihoods, and support sustainable agriculture
                and livestock-based economic opportunities in selected project areas.
            </p>
            <p>
                The project promotes inclusive development by linking rural communities with improved
                services, markets, infrastructure and climate-smart practices.
            </p>
        </div>

        <div class="col-lg-6">
            <div class="card feature-card p-4">
                <h5 class="fw-bold text-success">Project Identity</h5>
                <p><strong>Project Name:</strong> Integrated Rurban Development and Climate Resilience Project</p>
                <p><strong>Acronym:</strong> IRDCRP</p>
                <p><strong>Funding:</strong> World Bank funded project</p>
                <p><strong>Sector:</strong> Agriculture, Livestock, Climate Resilience and Rural Development</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background:#F7FAFC;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Project Objectives</h2>
            <p class="section-subtitle">
                IRDCRP supports sustainable development through resilience, productivity and inclusion.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <h5 class="fw-bold">Climate Resilience</h5>
                    <p>Enhance community capacity to adapt to climate-related risks and challenges.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <h5 class="fw-bold">Livelihood Development</h5>
                    <p>Improve income-generation opportunities through agriculture and livestock interventions.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <h5 class="fw-bold">Inclusive Growth</h5>
                    <p>Support rural and urban-linked communities through sustainable development solutions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection