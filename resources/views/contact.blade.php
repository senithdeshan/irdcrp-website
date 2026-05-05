@extends('layouts.app')

@section('content')

<section class="irdc-contact-modern relative overflow-hidden py-16 sm:py-20">
    <div class="irdc-contact-modern__bg absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-contact-modern__overlay absolute inset-0" aria-hidden="true"></div>
    <div class="irdc-contact-modern__wave-top" aria-hidden="true"></div>
    <div class="irdc-contact-modern__wave-bottom" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="irdc-contact-modern__glass">
            <header class="text-center">
                <h1 class="irdc-contact-modern__title">Drop us a message for any query</h1>
                <p class="irdc-contact-modern__subtitle">If you have an idea, we would love to hear about it.</p>
            </header>

            <form class="mt-6 grid gap-3 sm:grid-cols-2 sm:gap-4">
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
</section>

@endsection