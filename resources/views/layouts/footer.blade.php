@php
    $showPublicFooter = ! request()->is('admin*') && ! request()->routeIs('dashboard');
@endphp

@if($showPublicFooter)
<section class="irdc-footer-cta">
    <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 py-4 text-center sm:flex-row sm:px-6 sm:text-left lg:px-8">
        <p class="text-sm font-semibold text-white sm:text-base">Join us in building climate-resilient rural communities.</p>
        <a href="/contact" class="irdc-footer-cta__btn">Contact Us</a>
    </div>
</section>

<footer class="irdc-footer-modern">
    <div class="irdc-footer-modern__wave" aria-hidden="true">
        <svg viewBox="0 0 1200 90" preserveAspectRatio="none" class="h-10 w-full sm:h-12">
            <path fill="currentColor" d="M0,60 C160,18 330,88 500,44 C650,4 860,72 1020,36 C1110,16 1160,28 1200,18 L1200,90 L0,90 Z"></path>
        </svg>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 pb-6 pt-12 sm:px-6 sm:pt-14 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-10">
            <div>
                <div class="mb-4 flex items-center gap-3">
                    <img src="{{ asset(config('irdcrp.logos.irdcrp')) }}" alt="{{ __('messages.logo_irdcrp_alt') }}" class="h-14 w-auto rounded-md bg-white/90 p-1">
                    <p class="text-lg font-extrabold text-white">IRDCRP</p>
                </div>
                <p class="text-sm leading-relaxed text-white/80">
                    Integrated Rurban Development and Climate Resilience Project supports climate-smart development and resilient livelihoods.
                </p>
                <p class="mt-3 text-xs text-emerald-100/80">{{ config('irdcrp.ministry_line_en') }}</p>
            </div>

            <div>
                <h3 class="irdc-footer-modern__head">Quick Links</h3>
                <ul class="irdc-footer-modern__links">
                    <li><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                    <li><a href="/about">{{ __('messages.about') }}</a></li>
                    <li><a href="/components">{{ __('messages.nav_programmes') }}</a></li>
                    <li><a href="/news">{{ __('messages.nav_news') }}</a></li>
                    <li><a href="{{ route('gallery.section', 'audio') }}">{{ __('messages.nav_media_audio') }}</a></li>
                    <li><a href="{{ route('gallery.section', 'photos') }}">{{ __('messages.nav_media_photos') }}</a></li>
                    <li><a href="{{ route('gallery.section', 'videos') }}">{{ __('messages.nav_media_videos') }}</a></li>
                    <li><a href="{{ route('gallery.section', 'presentation') }}">{{ __('messages.nav_media_presentation') }}</a></li>
                    <li><a href="{{ route('gallery.section', 'voice') }}">{{ __('messages.nav_media_voice') }}</a></li>
                    <li><a href="/contact">{{ __('messages.contact') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="irdc-footer-modern__head">Project Focus</h3>
                <ul class="irdc-footer-modern__links">
                    <li><a href="/components">Climate Resilience</a></li>
                    <li><a href="/components">Water Management</a></li>
                    <li><a href="/components">Sustainable Agriculture</a></li>
                    <li><a href="/components">Livelihood Development</a></li>
                </ul>
            </div>

            <div>
                <h3 class="irdc-footer-modern__head">{{ __('messages.footer_contact') }}</h3>
                <p class="text-sm leading-relaxed text-white/80">{{ config('irdcrp.contact.address') }}</p>
                <p class="mt-2 text-sm text-white/90"><a href="mailto:{{ config('irdcrp.contact.email') }}" class="hover:text-emerald-200">{{ config('irdcrp.contact.email') }}</a></p>
                <p class="text-sm text-white/90"><a href="tel:{{ preg_replace('/\s+/', '', config('irdcrp.contact.phone')) }}" class="hover:text-emerald-200">{{ config('irdcrp.contact.phone') }}</a></p>

                <div class="mt-4 flex items-center gap-2.5">
                    <a href="{{ config('irdcrp.social.facebook') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="Facebook">
                        <img src="{{ asset(config('irdcrp.social_icons.facebook')) }}" alt="Facebook" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
                    </a>
                    <a href="{{ config('irdcrp.social.youtube') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="YouTube">
                        <img src="{{ asset(config('irdcrp.social_icons.youtube')) }}" alt="YouTube" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
                    </a>
                    <a href="{{ config('irdcrp.social.twitter') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="X">
                        <img src="{{ asset(config('irdcrp.social_icons.twitter')) }}" alt="X" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
                    </a>
                    <a href="{{ config('irdcrp.social.linkedin') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="LinkedIn">
                        <img src="{{ asset(config('irdcrp.social_icons.linkedin')) }}" alt="LinkedIn" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
                    </a>
                    <a href="{{ config('irdcrp.social.instagram') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="Instagram">
                        <img src="{{ asset(config('irdcrp.social_icons.instagram')) }}" alt="Instagram" class="h-5 w-5 rounded-sm object-contain" loading="lazy" decoding="async">
                    </a>
                </div>

                <form class="mt-5">
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-emerald-100/90">Newsletter</label>
                    <div class="flex gap-2">
                        <input type="email" placeholder="Your email" class="w-full rounded-full border border-emerald-200/30 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/60 focus:border-emerald-200 focus:outline-none">
                        <button type="button" class="rounded-full bg-amber-500 px-4 py-2 text-sm font-bold text-slate-900 transition hover:bg-amber-400">Join</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-10 border-t border-white/15 pt-5 text-center text-xs text-white/60">
            © {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.rights') }} · Developed by IRDCRP Team
        </div>
    </div>
</footer>
@endif
