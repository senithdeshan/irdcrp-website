@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Gallery</h1>
        <p class="lead mb-0">Project images and activities</p>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">

        @for ($i = 1; $i <= 6; $i++)
        <div class="col-md-4">
            <div class="card feature-card">
                <div style="height:200px; background:#EAF7F0;" class="d-flex align-items-center justify-content-center">
                    <span class="fs-1">📷</span>
                </div>
                <div class="card-body text-center">
                    <p class="mb-0">Image Caption</p>
                </div>
            </div>
        </div>
        @endfor

    </div>
</section>

@endsection