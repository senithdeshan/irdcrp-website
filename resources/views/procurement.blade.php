@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Procurement</h1>
        <p class="lead mb-0">Procurement notices, bidding documents and award information</p>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Procurement Notices</h2>
        <p class="section-subtitle">
            Official procurement opportunities and related documents of IRDCRP will be published here.
        </p>
    </div>

    <div class="card feature-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Reference No.</th>
                        <th>Title</th>
                        <th>Published Date</th>
                        <th>Closing Date</th>
                        <th>Status</th>
                        <th>Document</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>IRDCRP/PROC/001</td>
                        <td>Sample Procurement Notice</td>
                        <td>To be updated</td>
                        <td>To be updated</td>
                        <td><span class="badge bg-success">Open</span></td>
                        <td><a href="#" class="btn btn-green btn-sm">Download</a></td>
                    </tr>
                    <tr>
                        <td>IRDCRP/PROC/002</td>
                        <td>Sample Bid Award Information</td>
                        <td>To be updated</td>
                        <td>To be updated</td>
                        <td><span class="badge bg-secondary">Closed</span></td>
                        <td><a href="#" class="btn btn-green btn-sm">Download</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection