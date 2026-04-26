@php
    $showPublicFooter = ! request()->is('admin*') && ! request()->routeIs('dashboard');
@endphp

@if($showPublicFooter)
<section class="border-t border-slate-200/90 bg-slate-100/90 py-14 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500 mb-8">{{ __('messages.partners_title') }}</h2>
        <div class="irdc-partner-strip mx-auto" role="group" aria-label="Partner logos">
            <div class="irdc-partner-strip__cell">
                <img src="{{ asset(config('irdcrp.logos.irdcrp')) }}" alt="{{ __('messages.logo_irdcrp_alt') }}" loading="lazy" decoding="async">
            </div>
            <div class="irdc-partner-strip__cell irdc-partner-strip__cell--emblem">
                <img src="{{ asset(config('irdcrp.logos.emblem')) }}" alt="{{ __('messages.logo_emblem_alt') }}" loading="lazy" decoding="async">
            </div>
            <div class="irdc-partner-strip__cell irdc-partner-strip__cell--bank">
                <img src="{{ asset(config('irdcrp.logos.world_bank')) }}" alt="{{ __('messages.logo_world_bank_alt') }}" loading="lazy" decoding="async">
            </div>
        </div>
    </div>
</section>

<footer class="bg-[#0A3D62] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-10">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/90 border-b border-white/20 pb-2 mb-3">{{ __('messages.footer_overview') }}</h3>
                <p class="text-sm text-white/80 leading-relaxed">{{ __('messages.footer_overview_text') }}</p>
                <p class="mt-4 text-xs text-white/60 leading-relaxed border-t border-white/10 pt-3">{{ config('irdcrp.ministry_line_en') }}</p>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/90 border-b border-white/20 pb-2 mb-4">{{ __('messages.footer_quick_links') }}</h3>
                <ul class="space-y-2.5 text-sm text-white/85">
                    <li><a class="hover:text-white hover:underline" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                    <li><a class="hover:text-white hover:underline" href="{{ url('/#programmes') }}">{{ __('messages.nav_programmes') }}</a></li>
                    <li><a class="hover:text-white hover:underline" href="/about">{{ __('messages.about') }}</a></li>
                    <li><a class="hover:text-white hover:underline" href="/news">{{ __('messages.nav_news') }}</a></li>
                    <li><a class="hover:text-white hover:underline" href="/downloads">{{ __('messages.nav_downloads') }}</a></li>
                    <li><a class="hover:text-white hover:underline" href="/gallery">{{ __('messages.nav_gallery') }}</a></li>
                    <li><a class="hover:text-white hover:underline" href="/vacancies">{{ __('messages.nav_vacancies') }}</a></li>
                    <li><a class="hover:text-white hover:underline" href="/contact">{{ __('messages.contact') }}</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/90 border-b border-white/20 pb-2 mb-4">{{ __('messages.footer_contact') }}</h3>
                <p class="text-sm text-white/80 leading-relaxed">
                    <span class="text-white font-medium">{{ __('messages.address_label') }}</span><br>
                    {{ config('irdcrp.contact.address') }}
                </p>
                <p class="mt-4 text-sm text-white/80">
                    <a class="hover:underline" href="tel:{{ preg_replace('/\s+/', '', config('irdcrp.contact.phone')) }}">{{ config('irdcrp.contact.phone') }}</a>
                </p>
                <p class="text-sm text-white/80">
                    <a class="hover:underline" href="mailto:{{ config('irdcrp.contact.email') }}">{{ config('irdcrp.contact.email') }}</a>
                </p>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/90 border-b border-white/20 pb-2 mb-3">{{ __('messages.footer_social') }}</h3>
                <p class="text-sm text-white/70 mb-4">{{ __('messages.footer_social_hint') }}</p>
                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ config('irdcrp.social.facebook') }}" rel="noopener noreferrer" target="_blank" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-sm font-semibold text-white transition hover:bg-white/20" title="Facebook" aria-label="Facebook">f</a>
                    <a href="{{ config('irdcrp.social.youtube') }}" rel="noopener noreferrer" target="_blank" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-xs text-white transition hover:bg-white/20" title="YouTube" aria-label="YouTube">▶</a>
                    <a href="{{ config('irdcrp.social.twitter') }}" rel="noopener noreferrer" target="_blank" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white transition hover:bg-white/20" title="X" aria-label="X">X</a>
                </div>
            </div>
        </div>
        <p class="mt-12 pt-8 border-t border-white/15 text-center text-xs text-white/50">
            © {{ date('Y') }} {{ config('app.name') }} · {{ __('messages.rights') }}
        </p>
    </div>
</footer>
@endif
