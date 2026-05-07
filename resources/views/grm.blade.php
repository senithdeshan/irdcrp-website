@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Grievance Redress Mechanism (GRM)</h1>
        <p class="lead mb-0">Submit complaints, feedback or inquiries</p>
    </div>
</section>

<section class="container py-5">
    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="irdc-helpdesk-section">
        <aside class="irdc-helpdesk-card">
            <p class="irdc-helpdesk-label">CONTACT FOR GRM</p>
            <h2>Project Help Desk</h2>

            <div class="irdc-helpdesk-item">
                <h4>Email</h4>
                <a href="mailto:pmuirdcrp@gmail.com">pmuirdcrp@gmail.com</a>
                <a href="mailto:irdcrp_moa@agrimin.gov.lk">irdcrp_moa@agrimin.gov.lk</a>
            </div>

            <div class="irdc-helpdesk-item">
                <h4>Phone</h4>
                <a href="tel:0112877550">011 2877 550</a>
                <a href="tel:0112073044">011 2073 044</a>
            </div>

            <div class="irdc-helpdesk-item">
                <h4>Address</h4>
                <p>No 123/2, Pannipitiya Road, Battaramulla, Sri Lanka</p>
            </div>
        </aside>

        <div class="irdc-complaint-card">
            <h2>Submit a Complaint</h2>
            <form method="POST" action="{{ route('grm.complaints.store') }}">
                @csrf
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name')<p class="text-danger small mt-1 mb-0">{{ $message }}</p>@enderror

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')<p class="text-danger small mt-1 mb-0">{{ $message }}</p>@enderror

                <label>Message</label>
                <textarea rows="5" name="message" required>{{ old('message') }}</textarea>
                @error('message')<p class="text-danger small mt-1 mb-0">{{ $message }}</p>@enderror

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</section>

@endsection