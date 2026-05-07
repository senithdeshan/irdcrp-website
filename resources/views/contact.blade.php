@extends('layouts.app')

@section('content')

<section class="irdc-contact-modern relative overflow-hidden py-16 sm:py-20">

    <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <section class="irdc-contact-modern__details" aria-label="Project contact details">
            <div class="irdc-contact-modern__top-card">
                <article class="irdc-contact-modern__hero-card">
                    <div class="irdc-contact-icon" aria-hidden="true">📍</div>
                    <h2 class="irdc-contact-modern__hero-title">Address</h2>
                    <p class="irdc-contact-modern__hero-line">Project Management Unit</p>
                    <p class="irdc-contact-modern__hero-line">Integrated Rurban Development and Climate Resilience Project (IRDCRP)</p>
                    <div class="irdc-contact-modern__address-block">
                        <p>No 123/2, Pannipitiya Road, Battaramulla, Sri Lanka</p>
                    </div>
                </article>
            </div>

            <div class="irdc-contact-modern__mini-grid">
                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">✉</div>
                    <h3 class="irdc-contact-modern__mini-head">Email</h3>
                    <a href="mailto:pmuirdcrp@gmail.com" class="irdc-contact-modern__mini-link">pmuirdcrp@gmail.com</a>
                    <a href="mailto:irdcrp_moa@agrimin.gov.lk" class="irdc-contact-modern__mini-link">irdcrp_moa@agrimin.gov.lk</a>
                </article>

                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">☎</div>
                    <h3 class="irdc-contact-modern__mini-head">Call Us</h3>
                    <a href="tel:0112877550" class="irdc-contact-modern__mini-link">011 2877 550</a>
                </article>

                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">📠</div>
                    <h3 class="irdc-contact-modern__mini-head">Fax</h3>
                    <p class="irdc-contact-modern__mini-link">011 2073 044</p>
                </article>

                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">🌐</div>
                    <h3 class="irdc-contact-modern__mini-head">Web</h3>
                    <a href="https://www.irdcrp.lk" class="irdc-contact-modern__mini-link" rel="noopener noreferrer" target="_blank">www.irdcrp.lk</a>
                </article>
            </div>
        </section>

        <div class="irdc-contact-modern__glass">
            <header class="text-center">
                <h1 class="irdc-contact-modern__title">Drop us a message for any query</h1>
                <p class="irdc-contact-modern__subtitle">If you have an idea, we would love to hear about it.</p>
            </header>

            <div class="irdc-contact-modern__form-shell mt-6">
                <form class="grid gap-3 sm:grid-cols-2 sm:gap-4">
                    <input type="text" class="irdc-contact-input" placeholder="Name">
                    <input type="email" class="irdc-contact-input" placeholder="Email">
                    <input type="text" class="irdc-contact-input" placeholder="Phone">
                    <input type="text" class="irdc-contact-input" placeholder="Subject">
                    <textarea class="irdc-contact-input sm:col-span-2" rows="4" placeholder="Your Message"></textarea>
                    <div class="sm:col-span-2 mt-1 text-center">
                        <button type="button" class="irdc-contact-send-btn">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection