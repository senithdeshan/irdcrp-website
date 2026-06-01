@extends('layouts.app')

@section('title', 'FAQ - '.config('app.name'))

@section('content')
<section class="irdc-faq-hero">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-3xl">
            <p class="irdc-faq-hero__eyebrow">Support Desk</p>
            <h1 class="irdc-faq-hero__title">Frequently Asked Questions</h1>
            <p class="irdc-faq-hero__subtitle">Integrated Rurban Development and Climate Resilience Project (IRDCRP)</p>
            <p class="irdc-faq-hero__lead">
                Find quick answers about project services, public documents, announcements, vacancies, grievance support, and how to reach the project team.
            </p>
        </div>
    </div>
</section>

<section class="irdc-faq-section">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-14 sm:px-6 lg:grid-cols-[0.75fr_1.25fr] lg:px-8">
        <aside class="irdc-faq-panel">
            <span>FAQ</span>
            <h2>Need help finding information?</h2>
            <p>
                These answers are maintained by the admin team and can be updated any time from the content management area.
            </p>
            <a href="{{ url('/contact') }}">Contact support</a>
        </aside>

        <div class="irdc-faq-list">
            @foreach ($faqs as $faq)
                <details class="irdc-faq-item" @if($loop->first) open @endif>
                    <summary>
                        <span>{{ is_array($faq) ? $faq['question'] : $faq->question }}</span>
                        <i aria-hidden="true"></i>
                    </summary>
                    <div class="irdc-faq-answer">
                        {{ is_array($faq) ? $faq['answer'] : $faq->answer }}
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endsection
