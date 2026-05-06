@extends('layouts.app')

@section('content')
    @include('gallery.partials.subnav')

    <section class="border-b border-stone-200/90 bg-gradient-to-b from-stone-50 to-white">
        <div class="mx-auto max-w-6xl px-4 py-10 text-center sm:py-14">
            <h1 class="font-display text-3xl font-extrabold leading-tight tracking-tight text-slate-800 sm:text-4xl md:text-[2.4rem]">
                <span class="text-slate-800">IRDCRP</span>
                <span class="text-[#6B2B27]"> {{ __($titleKey) }}</span>
            </h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-500 sm:text-base">
                {{ __('messages.media_section_placeholder') }}
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-12 sm:py-16">
        <div class="rounded-2xl border border-dashed border-stone-300 bg-stone-50/80 px-6 py-14 text-center">
            <p class="text-slate-600">{{ __('messages.media_section_placeholder_body') }}</p>
        </div>
    </section>
@endsection
