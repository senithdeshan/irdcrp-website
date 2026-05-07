@extends('layouts.app')

@section('content')

<section class="irdc-about-modern relative isolate overflow-hidden py-16 sm:py-20">
    <div class="irdc-about-modern__bg absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-about-modern__overlay absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-about-modern__wave-top" aria-hidden="true"></div>
    <div class="irdc-about-modern__wave-bottom" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <header class="text-center">
            <h1 class="irdc-about-modern__title">About Us</h1>
            <p class="irdc-about-modern__subtitle">Learn More About Our Mission &amp; Goals</p>
        </header>

        <div class="mt-10 grid gap-4 sm:gap-5 md:grid-cols-2">
            <article class="irdc-about-glass-card">
                <h2 class="irdc-about-glass-card__title">Our Mission</h2>
                <p class="irdc-about-glass-card__text">
                    To enhance the resilience and livelihoods of rural communities through sustainable development,
                    water resource management, and climate adaptation.
                </p>
            </article>
            <article class="irdc-about-glass-card">
                <h2 class="irdc-about-glass-card__title">Our Objectives</h2>
                <p class="irdc-about-glass-card__text">
                    To resolve rural challenges, improve infrastructure, and foster inclusive growth through
                    practical and climate-smart project interventions.
                </p>
            </article>
        </div>

        <section class="irdc-about-panel mt-7 sm:mt-8">
            <h2 class="irdc-about-panel__heading">Conflicts Mediation &amp; Grievance Redressal</h2>
            <p class="irdc-about-panel__lead">
                We provide a transparent and systematic approach to addressing grievances and resolving conflicts
                within project areas.
            </p>
            <div class="mt-5 grid gap-4 sm:grid-cols-3">
                <article class="irdc-about-mini-card">
                    <h3>Fair Process</h3>
                    <p>Ensuring impartial and timely redress for all stakeholders.</p>
                </article>
                <article class="irdc-about-mini-card">
                    <h3>Safe &amp; Secure</h3>
                    <p>Protecting the rights and confidentiality of all participants.</p>
                </article>
                <article class="irdc-about-mini-card">
                    <h3>Community Trust</h3>
                    <p>Building confidence and cooperation through responsive grievance handling.</p>
                </article>
            </div>
        </section>

        <section class="irdc-about-panel mt-7 sm:mt-8">
            <h2 class="irdc-about-panel__heading">Why Choose Us?</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-3">
                <article class="irdc-about-mini-card">
                    <h3>Experienced Team</h3>
                    <p>Expertise you can trust across agriculture and climate resilience.</p>
                </article>
                <article class="irdc-about-mini-card">
                    <h3>Proven Results</h3>
                    <p>Positive impact and measurable outcomes in partner communities.</p>
                </article>
                <article class="irdc-about-mini-card">
                    <h3>Sustainable Approach</h3>
                    <p>Long-term, inclusive development with strong local ownership.</p>
                </article>
            </div>
        </section>
    </div>
</section>

@endsection