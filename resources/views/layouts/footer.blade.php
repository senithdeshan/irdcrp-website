@php
    $showPublicFooter = ! request()->is('admin*') && ! request()->routeIs('dashboard');
    $footer = $footerSettings ?? [];
    $footerLogo = $footer['logo'] ?? config('irdcrp.logos.irdcrp');
    $footerProjectName = $footer['project_name'] ?? config('irdcrp.project_name.en', config('app.name', 'IRDCRP'));
    $footerAddress = $footer['address'] ?? config('irdcrp.contact.address');
    $footerEmail = $footer['email'] ?? config('irdcrp.contact.email');
    $footerPhone = $footer['phone'] ?? config('irdcrp.contact.phone');
@endphp

@if($showPublicFooter)
<footer class="irdc-footer-modern">
    <div class="irdc-footer-modern__wave" aria-hidden="true">
        <svg viewBox="0 0 1200 90" preserveAspectRatio="none" class="h-10 w-full sm:h-12">
            <path fill="currentColor" d="M0,60 C160,18 330,88 500,44 C650,4 860,72 1020,36 C1110,16 1160,28 1200,18 L1200,90 L0,90 Z"></path>
        </svg>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 pb-6 pt-12 sm:px-6 sm:pt-14 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-[1.35fr_0.8fr_0.85fr] lg:gap-12">
            <div class="irdc-footer-modern__brand">
                <div class="irdc-footer-modern__identity">
                    <img src="{{ asset($footerLogo) }}" alt="{{ __('messages.logo_irdcrp_alt') }}" class="irdc-footer-modern__logo">
                    <div>
                        <p class="irdc-footer-modern__kicker">IRDCRP</p>
                        <h2 class="irdc-footer-modern__project">{{ $footerProjectName }}</h2>
                    </div>
                </div>

                <div class="irdc-footer-modern__contact-list">
                    @if(filled($footerAddress))
                        <p>{{ $footerAddress }}</p>
                    @endif

                    @if(filled($footerEmail))
                        <a href="mailto:{{ $footerEmail }}">{{ $footerEmail }}</a>
                    @endif

                    @if(filled($footerPhone))
                        <a href="tel:{{ preg_replace('/\s+/', '', $footerPhone) }}">{{ $footerPhone }}</a>
                    @endif
                </div>

                <div class="irdc-footer-modern__socials" aria-label="{{ __('messages.footer_social') }}">
                    <a href="{{ $socialLinks['facebook'] ?? config('irdcrp.social.facebook') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="Facebook">
                        <x-social-icon name="facebook" class="h-5 w-5" />
                    </a>
                    <a href="{{ $socialLinks['youtube'] ?? config('irdcrp.social.youtube') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="YouTube">
                        <x-social-icon name="youtube" class="h-5 w-5" />
                    </a>
                    <a href="{{ $socialLinks['twitter'] ?? config('irdcrp.social.twitter') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="X">
                        <x-social-icon name="x" class="h-5 w-5" />
                    </a>
                    <a href="{{ $socialLinks['linkedin'] ?? config('irdcrp.social.linkedin') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="LinkedIn">
                        <x-social-icon name="linkedin" class="h-5 w-5" />
                    </a>
                    <a href="{{ $socialLinks['instagram'] ?? config('irdcrp.social.instagram') }}" rel="noopener noreferrer" target="_blank" class="irdc-footer-modern__social" aria-label="Instagram">
                        <x-social-icon name="instagram" class="h-5 w-5" />
                    </a>
                </div>
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

            <div class="sm:col-span-2 lg:col-span-1">
                <h3 class="irdc-footer-modern__head">Project Focus</h3>
                <ul class="irdc-footer-modern__links">
                    <li><a href="/components">Climate Resilience</a></li>
                    <li><a href="/components">Water Management</a></li>
                    <li><a href="/components">Sustainable Agriculture</a></li>
                    <li><a href="/components">Livelihood Development</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-white/15 pt-5 text-center text-xs text-white/60">
            © {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.rights') }} · Developed by IRDCRP Team
        </div>
    </div>
</footer>
@endif
