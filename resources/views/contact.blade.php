@extends('layouts.app')

@section('content')

<section
    class="py-5 text-white"
    style="background:
        linear-gradient(120deg, rgba(10,61,98,0.72), rgba(39,174,96,0.55)),
        url('{{ asset('images/hero/about-modern-bg.png') }}') center/cover no-repeat;"
>
    <div class="container py-4">
        <h1 class="fw-bold">Contact Us</h1>
        <p class="lead mb-0">Get in touch with IRDCRP</p>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">

        <div class="col-lg-6">
            <div class="card feature-card p-4">
                <h4 class="fw-bold">Send a Message</h4>

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

                    <button class="btn btn-green">Send</button>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card feature-card p-4">
                <h4 class="fw-bold">Office Information</h4>
                <p><strong>Address:</strong> Ministry of Agriculture, Sri Lanka</p>
                <p><strong>Email:</strong> info@irdcrp.lk</p>
                <p><strong>Phone:</strong> +94 XX XXX XXXX</p>

                <div class="mt-3">
                    <iframe src="https://maps.google.com/maps?q=colombo&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        width="100%" height="200" style="border:0;"></iframe>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection