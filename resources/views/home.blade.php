@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold">
                    Integrated Rurban Development and Climate Resilience Project
                </h1>
                <p class="lead mt-3">
                    Building resilient rural and urban-linked communities through sustainable agriculture,
                    livestock development, climate resilience and inclusive economic growth.
                </p>
                <a href="/about" class="btn btn-light mt-3">Learn More</a>
                <a href="/contact" class="btn btn-outline-light mt-3 ms-2">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p>Districts</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p>Beneficiaries</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p>Project Components</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-success fw-bold">00</h3>
                <p>Project Period</p>
            </div>
        </div>
    </div>
</section>

@endsection