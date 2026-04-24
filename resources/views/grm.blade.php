@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Grievance Redress Mechanism (GRM)</h1>
        <p class="lead mb-0">Submit complaints, feedback or inquiries</p>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">

        <div class="col-lg-6">
            <div class="card feature-card p-4">
                <h4 class="fw-bold">Submit a Complaint</h4>

                <form>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Message</label>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>

                    <button class="btn btn-green">Submit</button>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card feature-card p-4">
                <h4 class="fw-bold">Contact for GRM</h4>
                <p><strong>Email:</strong> info@irdcrp.lk</p>
                <p><strong>Phone:</strong> +94 XX XXX XXXX</p>
                <p><strong>Address:</strong> Project Office, Sri Lanka</p>
            </div>
        </div>

    </div>
</section>

@endsection