@extends('layouts.app')

@section('content')
@php
    use App\Support\ContactLocation;

    $contactPage = ContactLocation::page();
    $emails = array_values(array_filter($contactPage['emails'] ?? [], fn ($email) => filled($email)));
@endphp

<section class="irdc-contact-modern relative overflow-hidden py-16 sm:py-20">

    <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <section class="irdc-contact-modern__details" aria-label="Project contact details">
            <x-contact-location-card />

            <div class="irdc-contact-modern__mini-grid">
                @if ($emails !== [])
                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">✉</div>
                    <h3 class="irdc-contact-modern__mini-head">Email</h3>
                    @foreach ($emails as $email)
                        <a href="mailto:{{ $email }}" class="irdc-contact-modern__mini-link">{{ $email }}</a>
                    @endforeach
                </article>
                @endif

                @if (filled($contactPage['phone'] ?? null))
                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">☎</div>
                    <h3 class="irdc-contact-modern__mini-head">Call Us</h3>
                    <a href="tel:{{ ContactLocation::phoneTel() }}" class="irdc-contact-modern__mini-link">{{ $contactPage['phone'] }}</a>
                </article>
                @endif

                @if (filled($contactPage['fax'] ?? null))
                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">📠</div>
                    <h3 class="irdc-contact-modern__mini-head">Fax</h3>
                    <p class="irdc-contact-modern__mini-link">{{ $contactPage['fax'] }}</p>
                </article>
                @endif

                @if (filled($contactPage['website_url'] ?? null))
                <article class="irdc-contact-modern__mini-card">
                    <div class="irdc-contact-icon" aria-hidden="true">🌐</div>
                    <h3 class="irdc-contact-modern__mini-head">Web</h3>
                    <a href="{{ $contactPage['website_url'] }}" class="irdc-contact-modern__mini-link" rel="noopener noreferrer" target="_blank">{{ $contactPage['website_label'] ?? $contactPage['website_url'] }}</a>
                </article>
                @endif
            </div>
        </section>

        <div class="irdc-contact-modern__glass">
            <header class="text-center">
                <h1 class="irdc-contact-modern__title">{{ $contactPage['form_title'] ?? 'Drop us a message for any query' }}</h1>
                <p class="irdc-contact-modern__subtitle">{{ $contactPage['form_subtitle'] ?? 'If you have an idea, we would love to hear about it.' }}</p>
            </header>

            @if (session('success'))
                <div class="alert alert-success mt-4 mb-0">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mt-4 mb-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="irdc-contact-modern__form-shell mt-6">
                <form method="POST" action="{{ route('support-messages.store') }}" class="grid gap-3 sm:grid-cols-2 sm:gap-4">
                    @csrf
                    <input type="text" name="name" value="{{ old('name') }}" class="irdc-contact-input" placeholder="Name" required>
                    <input type="email" name="email" value="{{ old('email') }}" class="irdc-contact-input" placeholder="Email" required>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="irdc-contact-input" placeholder="Phone">
                    <input type="text" name="subject" value="{{ old('subject') }}" class="irdc-contact-input" placeholder="Subject" required>
                    <textarea name="message" class="irdc-contact-input sm:col-span-2" rows="4" placeholder="Your Message" required>{{ old('message') }}</textarea>
                    <div class="sm:col-span-2 mt-1 text-center">
                        <button type="submit" class="irdc-contact-send-btn">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
