@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Project Areas</h1>
        <p class="lead mb-0">IRDCRP implementation locations and coverage areas</p>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Geographical Coverage</h2>
        <p class="section-subtitle">
            Project districts and intervention areas will be updated based on the official project design.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card feature-card p-4">
                <h4 class="fw-bold text-success">Coverage Summary</h4>
                <p><strong>Province:</strong> To be updated</p>
                <p><strong>Districts:</strong> To be updated</p>
                <p><strong>DS Divisions:</strong> To be updated</p>
                <p><strong>Beneficiary Communities:</strong> To be updated</p>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card feature-card p-4">
                <h4 class="fw-bold">District-wise Areas</h4>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>District</th>
                                <th>DS Divisions</th>
                                <th>Main Focus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>To be updated</td>
                                <td>To be updated</td>
                                <td>Climate Resilience / Agriculture / Livestock</td>
                            </tr>
                            <tr>
                                <td>To be updated</td>
                                <td>To be updated</td>
                                <td>Community Development / Livelihoods</td>
                            </tr>
                            <tr>
                                <td>To be updated</td>
                                <td>To be updated</td>
                                <td>Infrastructure / Natural Resources</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection