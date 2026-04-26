@php
    $onHome = request()->is('/');
    $navLink = 'irdc-nav-link relative inline-flex items-center px-1.5 py-2 text-xs font-semibold tracking-wide font-display border-b-[3px] transition sm:px-2 sm:text-sm md:px-2.5 md:text-base lg:px-3';
    $active = 'border-emerald-300 text-white font-bold [text-shadow:0_1px_2px_rgba(0,0,0,0.12)] after:pointer-events-none after:absolute after:bottom-1.5 after:left-1/2 after:h-1.5 after:w-1.5 after:-translate-x-1/2 after:rounded-full after:bg-emerald-200 after:ring-2 after:ring-emerald-500/20 sm:after:bottom-2';
    $inactive = 'border-transparent text-white/90 hover:text-white hover:border-white/20';
@endphp

<header
    x-data="{ mobile: false, navSolid: false }"
    @if($onHome)
        @scroll.window="navSolid = (window.pageYOffset > 20)"
    @endif
    @class([
        'z-50',
        'fixed top-0 left-0 right-0' => $onHome,
        'relative' => ! $onHome,
    ])
>
    <div
        @if($onHome)
            class="irdc-top-bar irdc-top-bar--slim border-b border-slate-200/80 bg-white/95 transition-all duration-300 supports-[backdrop-filter]:backdrop-blur-sm"
            :class="navSolid ? 'shadow-sm ring-1 ring-slate-900/[0.04]' : ''"
        @else
            class="irdc-top-bar irdc-top-bar--slim border-b border-slate-200/80 bg-white/95"
        @endif
    >
        <div class="relative z-10 mx-auto max-w-7xl px-3 sm:px-5 lg:px-8 py-1.5 sm:py-2">
            <div
                class="irdc-top-bar__row flex w-full min-w-0 items-center justify-between gap-2 sm:gap-4"
            >
                {{-- Logos (left) --}}
                <div class="min-w-0 flex flex-1 justify-start overflow-hidden">
                    <div
                        class="irdc-header-logo-parts"
                        role="group"
                        aria-label="{{ __('messages.logos_aria') }}"
                    >
                        <div class="irdc-header-logo-cell" title="{{ __('messages.logo_emblem_alt') }}">
                            <img
                                src="{{ asset(config('irdcrp.logos.emblem')) }}"
                                alt="{{ __('messages.logo_emblem_alt') }}"
                                loading="eager"
                                decoding="async"
                            >
                        </div>
                        <a href="{{ url('/') }}" class="irdc-header-logo-cell" title="{{ config('app.name', 'IRDCRP') }}">
                            <img
                                src="{{ asset(config('irdcrp.logos.irdcrp')) }}"
                                alt="{{ __('messages.logo_irdcrp_alt') }}"
                                width="220"
                                height="80"
                                loading="eager"
                                decoding="async"
                            >
                        </a>
                        <div class="irdc-header-logo-cell" title="{{ __('messages.logo_world_bank_alt') }}">
                            <img
                                src="{{ asset(config('irdcrp.logos.world_bank')) }}"
                                alt="{{ __('messages.logo_world_bank_alt') }}"
                                loading="eager"
                                decoding="async"
                            >
                        </div>
                    </div>
                </div>

                {{-- Social + language + login --}}
                <div
                    class="irdc-header-tools irdc-header-tools--slim flex shrink-0 min-w-0 items-center justify-end gap-1.5 sm:gap-2"
                >
                    <div
                        class="irdc-header-tools__cluster flex min-w-0 max-w-full flex-nowrap items-center justify-end gap-1 sm:gap-1.5"
                    >
                        <div
                            class="inline-flex items-center gap-0.5 rounded-full border border-emerald-200/80 bg-white p-0.5 shadow-sm"
                            aria-label="{{ __('messages.header_social_aria') }}"
                        >
                            <a
                                class="irdc-header-social"
                                href="{{ config('irdcrp.social.facebook') }}"
                                rel="noopener noreferrer"
                                target="_blank"
                                title="Facebook"
                            >
                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.023 24 18.062 24 12.073z"
                                    />
                                </svg>
                            </a>
                            <a
                                class="irdc-header-social"
                                href="{{ config('irdcrp.social.youtube') }}"
                                rel="noopener noreferrer"
                                target="_blank"
                                title="YouTube"
                            >
                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 7.07 0 9.521 0 12s0 4.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136c.502-.914.502-3.365.502-5.814s0-4.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"
                                    />
                                </svg>
                            </a>
                            <a
                                class="irdc-header-social"
                                href="{{ config('irdcrp.social.linkedin') }}"
                                rel="noopener noreferrer"
                                target="_blank"
                                title="LinkedIn"
                            >
                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                                    />
                                </svg>
                            </a>
                        </div>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button type="button" class="irdc-top-bar__lang">
                                    <span aria-hidden="true" class="text-sm leading-none opacity-90">🌐</span>
                                    <span class="font-display text-xs font-bold tracking-wide sm:text-sm">{{ strtoupper(substr(app()->getLocale(), 0, 2)) }}</span>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="/lang/en">English</x-dropdown-link>
                                <x-dropdown-link href="/lang/si">සිංහල</x-dropdown-link>
                                <x-dropdown-link href="/lang/ta">தமிழ்</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                                <button type="submit" class="irdc-top-bar__auth-out" title="{{ __('messages.logout') }}">{{ __('messages.logout') }}</button>
                            </form>
                        @endauth
                        @guest
                            <a href="/login" class="irdc-top-bar__auth-in" title="{{ __('messages.login') }}">{{ __('messages.login') }}</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="irdc-main-nav border-b border-emerald-950/25 bg-irdc-green shadow-sm">
        <div class="mx-auto max-w-7xl px-3 sm:px-5 lg:px-8">
            <div class="flex w-full min-h-11 items-center justify-end md:min-h-12 md:justify-center">
                <nav class="irdc-main-nav__links hidden w-full flex-1 flex-wrap items-center justify-center gap-x-0 gap-y-0.5 py-1 sm:gap-x-0.5 md:flex lg:gap-y-1">
                    <a href="{{ url('/') }}" class="{{ $navLink }} {{ request()->is('/') ? $active : $inactive }}">{{ __('messages.home') }}</a>
                    <a href="/about" class="{{ $navLink }} {{ request()->is('about') ? $active : $inactive }}">{{ __('messages.about') }}</a>
                    <a href="{{ url('/#programmes') }}" class="{{ $navLink }} {{ $inactive }}">{{ __('messages.nav_programmes') }}</a>
                    <a href="/areas" class="{{ $navLink }} {{ request()->is('areas') ? $active : $inactive }}">{{ __('messages.nav_areas') }}</a>
                    <a href="/components" class="{{ $navLink }} {{ request()->is('components') ? $active : $inactive }}">{{ __('messages.nav_components') }}</a>
                    <a href="/news" class="{{ $navLink }} {{ request()->is('news*') ? $active : $inactive }}">{{ __('messages.nav_news') }}</a>
                    <a href="/procurement" class="{{ $navLink }} {{ request()->is('procurement*') ? $active : $inactive }}">{{ __('messages.nav_procurement') }}</a>
                    <a href="/downloads" class="{{ $navLink }} {{ request()->is('downloads') ? $active : $inactive }}">{{ __('messages.nav_downloads') }}</a>
                    <a href="/gallery" class="{{ $navLink }} {{ request()->is('gallery*') ? $active : $inactive }}">{{ __('messages.nav_gallery') }}</a>
                    <a href="/vacancies" class="{{ $navLink }} {{ request()->is('vacancies*') ? $active : $inactive }}">{{ __('messages.nav_vacancies') }}</a>
                    <a href="/grm" class="{{ $navLink }} {{ request()->is('grm') ? $active : $inactive }}">{{ __('messages.nav_grm') }}</a>
                    <a href="/contact" class="{{ $navLink }} {{ request()->is('contact') ? $active : $inactive }}">{{ __('messages.contact') }}</a>
                    @auth
                        <a href="{{ route('admin.home') }}" class="{{ $navLink }} {{ request()->is('admin*') ? $active : $inactive }}">Admin</a>
                    @endauth
                </nav>
                <button type="button" @click="mobile = ! mobile" class="shrink-0 p-2 text-white/95 md:hidden" aria-label="Menu">
                    <span x-show="!mobile" class="text-2xl leading-none">☰</span>
                    <span x-show="mobile" x-cloak class="text-2xl leading-none">×</span>
                </button>
            </div>
        </div>
        <div x-show="mobile" x-cloak @click.away="mobile = false" x-transition class="md:hidden max-h-[min(70vh,28rem)] overflow-y-auto border-t border-white/15 bg-irdc-green">
            <div class="mx-auto max-w-7xl space-y-0 px-3 pb-4 text-sm font-semibold font-display sm:px-5 sm:text-base lg:px-8">
                <a class="block border-b border-white/10 py-3 text-white/95" href="{{ url('/') }}">{{ __('messages.home') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/about">{{ __('messages.about') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="{{ url('/#programmes') }}">{{ __('messages.nav_programmes') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/areas">{{ __('messages.nav_areas') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/components">{{ __('messages.nav_components') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/news">{{ __('messages.nav_news') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/procurement">{{ __('messages.nav_procurement') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/downloads">{{ __('messages.nav_downloads') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/gallery">{{ __('messages.nav_gallery') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/vacancies">{{ __('messages.nav_vacancies') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/grm">{{ __('messages.nav_grm') }}</a>
                <a class="block border-b border-white/10 py-3 text-white/95" href="/contact">{{ __('messages.contact') }}</a>
                @auth
                    <a class="block py-3 text-amber-200" href="{{ route('admin.home') }}">Admin</a>
                @endauth
            </div>
        </div>
    </div>
</header>

```
