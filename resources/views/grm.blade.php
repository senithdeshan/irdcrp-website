@extends('layouts.app')

@section('content')

<section class="py-5 text-white" style="background: linear-gradient(120deg, #0A3D62, #27AE60);">
    <div class="container py-4">
        <h1 class="fw-bold">Grievance Redress Mechanism (GRM)</h1>
        <p class="lead mb-0">Submit complaints, feedback or inquiries</p>
    </div>
</section>

<section class="container py-5">
    <div class="grm-modern-grid">
        <div class="grm-modern-form">
            <h4 class="grm-modern-form__title">Submit a Complaint</h4>
            <form>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control grm-modern-form__input">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control grm-modern-form__input">
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea class="form-control grm-modern-form__input" rows="4"></textarea>
                </div>

                <button class="btn btn-green">Submit</button>
            </form>
        </div>

        <aside class="grm-modern-card">
            <p class="grm-modern-card__eyebrow">Contact for GRM</p>
            <h3 class="grm-modern-card__title">Project Help Desk</h3>

            <div class="grm-modern-card__block">
                <p class="grm-modern-card__label">Email</p>
                <a href="mailto:pmuirdcrp@gmail.com" class="grm-modern-card__link">pmuirdcrp@gmail.com</a>
                <a href="mailto:irdcrp_moa@agrimin.gov.lk" class="grm-modern-card__link">irdcrp_moa@agrimin.gov.lk</a>
            </div>

            <div class="grm-modern-card__block">
                <p class="grm-modern-card__label">Phone</p>
                <a href="tel:0112877550" class="grm-modern-card__link">011 2877 550</a>
                <a href="tel:0112073044" class="grm-modern-card__link">011 2073 044</a>
            </div>

            <div class="grm-modern-card__block">
                <p class="grm-modern-card__label">Address</p>
                <p class="grm-modern-card__text">No 123/2, Pannipitiya Road, Battaramulla, Sri Lanka</p>
            </div>
        </aside>
    </div>
</section>

@endsection