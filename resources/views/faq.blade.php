@extends('layouts.app')

@section('title', 'FAQ - '.config('app.name'))

@section('content')
<section class="bg-gradient-to-br from-[#0A3D62] via-emerald-800 to-emerald-600 py-16 text-white">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-100">Support</p>
        <h1 class="mt-3 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">Frequently Asked Questions</h1>
        <p class="mt-4 max-w-3xl text-base leading-relaxed text-white/85">
            Common information about IRDCRP services, public documents, announcements, and grievance support.
        </p>
    </div>
</section>

<section class="bg-white py-14">
    <div class="mx-auto grid max-w-5xl gap-4 px-4 sm:px-6 lg:px-8">
        @foreach ([
            ['Where can I find project documents?', 'Use the Resources menu and open Documents to view published reports, forms, and official public files.'],
            ['Where are procurement notices published?', 'Procurement opportunities are available under Announcements, then Procurement.'],
            ['How can I submit a complaint or grievance?', 'Open GRM from the main navigation and complete the complaint form with your contact details and message.'],
            ['Where can I find vacancies?', 'Vacancy notices are listed under Announcements, then Vacancy.'],
            ['How can I contact the project team?', 'Use Contact Us in the navigation to view contact details and send a support message.'],
        ] as $item)
            <article class="rounded-xl border border-slate-200 bg-slate-50/80 p-5 shadow-sm">
                <h2 class="font-display text-lg font-extrabold text-[#0A3D62]">{{ $item[0] }}</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">{{ $item[1] }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection
