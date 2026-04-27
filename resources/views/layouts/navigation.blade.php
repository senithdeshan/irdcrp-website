@php
    $onHome = request()->is('/');
    $navLink = 'irdc-nav-link relative inline-flex items-center rounded-md px-2 py-2.5 text-sm font-semibold tracking-wide font-display border-b-[3px] transition-colors duration-200 sm:px-2.5 sm:text-base md:px-3 md:text-lg lg:px-3.5 lg:text-[1.0625rem]';
    $active = 'border-emerald-300 bg-white/10 text-white font-bold shadow-sm [text-shadow:0_1px_2px_rgba(0,0,0,0.12)] after:pointer-events-none after:absolute after:bottom-1.5 after:left-1/2 after:h-1.5 after:w-1.5 after:-translate-x-1/2 after:rounded-full after:bg-emerald-200 after:ring-2 after:ring-emerald-500/25 sm:after:bottom-2';
    $inactive = 'border-transparent text-white/90 hover:border-white/25 hover:bg-white/10 hover:text-white';
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
        <div class="relative z-10 mx-auto max-w-7xl px-3 py-2 sm:px-5 sm:py-2.5 lg:px-8">
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
                        <div class="irdc-header-logo-cell irdc-header-logo-cell--emblem" title="{{ __('messages.logo_emblem_alt') }}">
                            <img
                                src="{{ asset(config('irdcrp.logos.emblem')) }}"
                                alt="{{ __('messages.logo_emblem_alt') }}"
                                loading="eager"
                                decoding="async"
                            >
                        </div>
                        <a href="{{ url('/') }}" class="irdc-header-logo-cell irdc-header-logo-cell--irdcrp" title="{{ config('app.name', 'IRDCRP') }}">
                            <img
                                src="{{ asset(config('irdcrp.logos.irdcrp')) }}"
                                alt="{{ __('messages.logo_irdcrp_alt') }}"
                                width="200"
                                height="256"
                                loading="eager"
                                decoding="async"
                            >
                        </a>
                        <div class="irdc-header-logo-cell irdc-header-logo-cell--worldbank" title="{{ __('messages.logo_world_bank_alt') }}">
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

    <div class="irdc-main-nav border-b border-emerald-950/30 bg-irdc-green shadow-md shadow-emerald-950/20 ring-1 ring-white/10">
        <div class="mx-auto max-w-7xl px-3 sm:px-5 lg:px-8">
            <div class="flex w-full min-h-[3.25rem] items-center justify-end md:min-h-14 md:justify-center">
                <nav id="main-nav-desktop" class="irdc-main-nav__links hidden w-full flex-1 flex-wrap items-center justify-center gap-x-0.5 gap-y-1.5 py-2 sm:gap-x-1 md:flex" aria-label="{{ __('messages.nav_primary_aria') }}">
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
                <button
                    type="button"
                    id="main-nav-toggle"
                    @click="mobile = ! mobile"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-200/80 md:hidden"
                    :aria-expanded="mobile"
                    aria-controls="main-nav-mobile"
                    aria-label="{{ __('messages.nav_menu_toggle') }}"
                >
                    <svg x-show="!mobile" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobile" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div
            id="main-nav-mobile"
            x-show="mobile"
            x-cloak
            @click.away="mobile = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="md:hidden max-h-[min(75vh,32rem)] overflow-y-auto border-t border-white/20 bg-irdc-green/98 shadow-inner backdrop-blur-sm"
            role="navigation"
            aria-label="{{ __('messages.nav_primary_aria') }}"
        >
            <div class="mx-auto max-w-7xl space-y-0 px-3 pb-5 pt-1 text-base font-semibold font-display sm:px-5 sm:text-lg lg:px-8">
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="{{ url('/') }}" @click="mobile = false">{{ __('messages.home') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/about" @click="mobile = false">{{ __('messages.about') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="{{ url('/#programmes') }}" @click="mobile = false">{{ __('messages.nav_programmes') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/areas" @click="mobile = false">{{ __('messages.nav_areas') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/components" @click="mobile = false">{{ __('messages.nav_components') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/news" @click="mobile = false">{{ __('messages.nav_news') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/procurement" @click="mobile = false">{{ __('messages.nav_procurement') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/downloads" @click="mobile = false">{{ __('messages.nav_downloads') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/gallery" @click="mobile = false">{{ __('messages.nav_gallery') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/vacancies" @click="mobile = false">{{ __('messages.nav_vacancies') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/grm" @click="mobile = false">{{ __('messages.nav_grm') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white/95 transition hover:bg-white/10 hover:text-white" href="/contact" @click="mobile = false">{{ __('messages.contact') }}</a>
                @auth
                    <a class="mt-2 block rounded-lg py-3.5 pl-1 text-amber-200 transition hover:bg-white/10" href="{{ route('admin.home') }}" @click="mobile = false">Admin</a>
                @endauth
            </div>
        </div>
    </div>
</header>

```
