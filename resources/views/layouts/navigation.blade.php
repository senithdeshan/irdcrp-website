@php
    $onHome = request()->is('/');
    $inGallery = request()->is('gallery*');
    $inGrm = request()->is('grm*') || request()->is('admin/grm-complaints*');
    $navLink = 'irdc-nav-link relative inline-flex items-center whitespace-nowrap rounded-md px-2 py-2.5 text-sm font-semibold tracking-wide font-display border-b-[3px] transition-colors duration-300 sm:px-2.5 sm:text-base md:px-3 md:text-lg lg:px-3.5 lg:text-[1.0625rem]';
    $active = 'border-emerald-300 bg-white/10 text-white font-bold shadow-sm [text-shadow:0_1px_2px_rgba(0,0,0,0.12)] after:pointer-events-none after:absolute after:bottom-1.5 after:left-1/2 after:h-1.5 after:w-1.5 after:-translate-x-1/2 after:rounded-full after:bg-emerald-200 after:ring-2 after:ring-emerald-500/25 hover:text-irdc-nav-hover sm:after:bottom-2';
    /* No ::after dot: avoids overlap with the dropdown panel; chevron marks the control */
    $activeGalleryNav = 'border-emerald-300 bg-white/10 text-white font-bold shadow-sm [text-shadow:0_1px_2px_rgba(0,0,0,0.12)] after:hidden hover:text-irdc-nav-hover';
    $inactive = 'border-transparent text-white hover:border-white/20 hover:bg-white/10 hover:text-irdc-nav-hover';
@endphp

<header
    x-data="{ mobile: false, navSolid: false, galleryMobile: @js($inGallery) }"
    @if($onHome)
        @scroll.window="navSolid = (window.pageYOffset > 20)"
    @endif
    @class([
        'z-[9999]',
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
            <div class="irdc-top-bar__row flex w-full min-w-0 items-center justify-between gap-2 sm:gap-4">

                <div class="min-w-0 flex flex-1 justify-start overflow-hidden">
                    <div class="irdc-header-logo-parts" role="group" aria-label="{{ __('messages.logos_aria') }}">
                        <div class="irdc-header-logo-cell irdc-header-logo-cell--emblem" title="{{ __('messages.logo_emblem_alt') }}">
                            <img src="{{ asset(config('irdcrp.logos.emblem')) }}" alt="{{ __('messages.logo_emblem_alt') }}" loading="eager" decoding="async">
                        </div>

                        <a href="{{ url('/') }}" class="irdc-header-logo-cell irdc-header-logo-cell--irdcrp" title="{{ config('app.name', 'IRDCRP') }}">
                            <img src="{{ asset(config('irdcrp.logos.irdcrp')) }}" alt="{{ __('messages.logo_irdcrp_alt') }}" width="200" height="256" loading="eager" decoding="async">
                        </a>

                        <div class="irdc-header-logo-cell irdc-header-logo-cell--worldbank" title="{{ __('messages.logo_world_bank_alt') }}">
                            <img src="{{ asset(config('irdcrp.logos.world_bank')) }}" alt="{{ __('messages.logo_world_bank_alt') }}" loading="eager" decoding="async">
                        </div>
                    </div>
                </div>

                <div class="irdc-header-tools irdc-header-tools--slim flex shrink-0 min-w-0 items-center justify-end gap-1.5 sm:gap-2">
                    <div class="irdc-header-tools__cluster flex min-w-0 max-w-full flex-nowrap items-center justify-end gap-1 sm:gap-1.5">

                        <div class="inline-flex items-center gap-0.5 rounded-full border border-emerald-200/80 bg-white p-0.5 shadow-sm" aria-label="{{ __('messages.header_social_aria') }}">
                            <a class="irdc-header-social" href="{{ config('irdcrp.social.facebook') }}" rel="noopener noreferrer" target="_blank" title="Facebook">f</a>
                            <a class="irdc-header-social" href="{{ config('irdcrp.social.youtube') }}" rel="noopener noreferrer" target="_blank" title="YouTube">▶</a>
                            <a class="irdc-header-social" href="{{ config('irdcrp.social.linkedin') }}" rel="noopener noreferrer" target="_blank" title="LinkedIn">in</a>
                        </div>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button type="button" class="irdc-top-bar__lang">
                                    <span aria-hidden="true" class="text-sm leading-none opacity-90">🌐</span>
                                    <span class="font-display text-xs font-bold tracking-wide sm:text-sm">
                                        {{ strtoupper(substr(app()->getLocale(), 0, 2)) }}
                                    </span>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="/lang/en">English</x-dropdown-link>
                                <x-dropdown-link href="/lang/si">සිංහල</x-dropdown-link>
                                <x-dropdown-link href="/lang/ta">தமிழ்</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="irdc-top-bar__auth-out" title="{{ __('messages.logout') }}">
                                    {{ __('messages.logout') }}
                                </button>
                            </form>
                        @endauth

                        @guest
                            <a href="/login" class="irdc-top-bar__auth-in" title="{{ __('messages.login') }}">
                                {{ __('messages.login') }}
                            </a>
                        @endguest

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="irdc-main-nav overflow-visible border-b border-emerald-950/25 bg-irdc-bar-green shadow-md shadow-emerald-950/25 ring-1 ring-white/10">
        <div class="mx-auto max-w-7xl overflow-visible px-3 py-1.5 sm:px-5 lg:px-8">
            <div class="flex w-full min-h-[3.25rem] items-center justify-end gap-2 overflow-visible md:min-h-14 md:justify-between">

                <nav id="main-nav-desktop" class="irdc-main-nav__links hidden w-full flex-1 flex-col items-center justify-center gap-y-0.5 overflow-visible py-0 md:flex" aria-label="{{ __('messages.nav_primary_aria') }}">
                    <div class="irdc-main-nav__row flex w-full flex-wrap items-center justify-center gap-x-0.5 gap-y-1 overflow-visible sm:gap-x-1">
                        <a href="{{ url('/') }}" class="{{ $navLink }} {{ request()->is('/') ? $active : $inactive }}">{{ __('messages.home') }}</a>
                        <a href="/about" class="{{ $navLink }} {{ request()->is('about') ? $active : $inactive }}">{{ __('messages.about') }}</a>
                        <a href="/components" class="{{ $navLink }} {{ request()->is('components') ? $active : $inactive }}">{{ __('messages.nav_programmes') }}</a>
                        <a href="/areas" class="{{ $navLink }} {{ request()->is('areas') ? $active : $inactive }}">{{ __('messages.nav_areas') }}</a>
                        <a href="/components" class="{{ $navLink }} {{ request()->is('components') ? $active : $inactive }}">{{ __('messages.nav_components') }}</a>
                        <a href="/news" class="{{ $navLink }} {{ request()->is('news*') ? $active : $inactive }}">{{ __('messages.nav_news') }}</a>
                        <a href="/procurement" class="{{ $navLink }} {{ request()->is('procurement*') ? $active : $inactive }}">{{ __('messages.nav_procurement') }}</a>
                        <a href="/downloads" class="{{ $navLink }} {{ request()->is('downloads') ? $active : $inactive }}">{{ __('messages.nav_downloads') }}</a>
                        <x-dropdown
                            align="left"
                            width="w-max max-w-[13rem]"
                            panelMinWidth=""
                            panelRounded="rounded-lg"
                            panelExtraClass="shadow-[0_6px_18px_rgba(0,0,0,0.12)]"
                            contentClasses="bg-white py-1 [&>a]:!px-3 [&>a]:!py-2 [&>a]:!text-sm [&>a]:!leading-snug [&>a:hover]:!pl-4"
                        >
                            <x-slot name="trigger">
                                <button
                                    type="button"
                                    class="group {{ $navLink }} {{ $inGallery ? $activeGalleryNav : $inactive }} !inline-flex max-w-max items-center gap-1"
                                    aria-haspopup="true"
                                >
                                    <span class="whitespace-nowrap">{{ __('messages.nav_gallery') }}</span>
                                    <span class="inline-flex shrink-0 text-white/75 transition-colors duration-300 group-hover:text-irdc-nav-hover" aria-hidden="true">
                                        <svg width="11" height="11" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-[11px] w-[11px] max-h-[11px] max-w-[11px]">
                                            <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                                        </svg>
                                    </span>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('gallery.section', 'audio') }}">{{ __('messages.nav_media_audio') }}</x-dropdown-link>
                                <x-dropdown-link href="{{ route('gallery.section', 'photos') }}">{{ __('messages.nav_media_photos') }}</x-dropdown-link>
                                <x-dropdown-link href="{{ route('gallery.section', 'videos') }}">{{ __('messages.nav_media_videos') }}</x-dropdown-link>
                                <x-dropdown-link href="{{ route('gallery.section', 'presentation') }}">{{ __('messages.nav_media_presentation') }}</x-dropdown-link>
                                <x-dropdown-link href="{{ route('gallery.section', 'voice') }}">{{ __('messages.nav_media_voice') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="irdc-main-nav__row flex w-full flex-wrap items-center justify-center gap-x-0.5 gap-y-1 overflow-visible sm:gap-x-1">
                        <a href="/vacancies" class="{{ $navLink }} {{ request()->is('vacancies*') ? $active : $inactive }}">{{ __('messages.nav_vacancies') }}</a>
                        <x-dropdown
                            align="left"
                            width="w-max max-w-[13rem]"
                            panelMinWidth=""
                            panelRounded="rounded-lg"
                            panelExtraClass="shadow-[0_6px_18px_rgba(0,0,0,0.12)]"
                            contentClasses="bg-white py-1 [&>a]:!px-3 [&>a]:!py-2 [&>a]:!text-sm [&>a]:!leading-snug [&>a:hover]:!pl-4"
                        >
                            <x-slot name="trigger">
                                <button
                                    type="button"
                                    class="group {{ $navLink }} {{ $inGrm ? $activeGalleryNav : $inactive }} !inline-flex max-w-max items-center gap-1"
                                    aria-haspopup="true"
                                >
                                    <span class="whitespace-nowrap">{{ __('messages.nav_grm') }}</span>
                                    <span class="inline-flex shrink-0 text-white/75 transition-colors duration-300 group-hover:text-irdc-nav-hover" aria-hidden="true">
                                        <svg width="11" height="11" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-[11px] w-[11px] max-h-[11px] max-w-[11px]">
                                            <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                                        </svg>
                                    </span>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="/grm">Submit complaint</x-dropdown-link>
                                @auth
                                    <x-dropdown-link href="{{ route('admin.grm-complaints.index') }}">Admin GRM inbox</x-dropdown-link>
                                @endauth
                            </x-slot>
                        </x-dropdown>
                        <a href="/contact" class="{{ $navLink }} {{ request()->is('contact') ? $active : $inactive }}">{{ __('messages.contact') }}</a>

                        @auth
                            <a href="{{ route('admin.home') }}" class="{{ $navLink }} {{ request()->is('admin*') ? $active : $inactive }}">Admin</a>
                        @endauth
                    </div>
                </nav>

                <a href="{{ url('/contact') }}" class="irdc-nav-cta hidden md:inline-flex">
                    {{ __('messages.home_get_involved') }}
                </a>

                <button
                    type="button"
                    id="main-nav-toggle"
                    @click="mobile = ! mobile"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-200/80 md:hidden"
                    :aria-expanded="mobile"
                    aria-controls="main-nav-mobile"
                    aria-label="{{ __('messages.nav_menu_toggle') }}"
                >
                    <svg x-show="!mobile" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg x-show="mobile" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            class="md:hidden max-h-[min(75vh,32rem)] overflow-y-auto border-t border-white/20 bg-irdc-bar-green/98 shadow-inner backdrop-blur-sm"
            role="navigation"
            aria-label="{{ __('messages.nav_primary_aria') }}"
        >
            <div class="mx-auto max-w-7xl space-y-0 px-3 pb-5 pt-1 text-base font-semibold font-display sm:px-5 sm:text-lg lg:px-8">
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="{{ url('/') }}" @click="mobile = false">{{ __('messages.home') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/about" @click="mobile = false">{{ __('messages.about') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/components" @click="mobile = false">{{ __('messages.nav_programmes') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/areas" @click="mobile = false">{{ __('messages.nav_areas') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/components" @click="mobile = false">{{ __('messages.nav_components') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/news" @click="mobile = false">{{ __('messages.nav_news') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/procurement" @click="mobile = false">{{ __('messages.nav_procurement') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/downloads" @click="mobile = false">{{ __('messages.nav_downloads') }}</a>
                <div class="border-b border-white/10">
                    <button
                        type="button"
                        id="main-nav-gallery-toggle"
                        class="flex w-full items-center justify-between rounded-lg py-3.5 pl-1 pr-1 text-start text-white/95 transition hover:bg-white/10 hover:text-white"
                        @click="galleryMobile = ! galleryMobile"
                        :aria-expanded="galleryMobile"
                        aria-controls="main-nav-gallery-sub"
                    >
                        <span class="{{ $inGallery ? 'font-bold text-white' : '' }}">{{ __('messages.nav_gallery') }}</span>
                        <span class="inline-flex shrink-0 text-white/70 transition-transform duration-200" :class="galleryMobile ? 'rotate-180' : ''" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-3.5 w-3.5 max-h-[14px] max-w-[14px]">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                            </svg>
                        </span>
                    </button>
                    <div
                        id="main-nav-gallery-sub"
                        x-show="galleryMobile"
                        x-cloak
                        class="space-y-0 border-t border-white/10 bg-emerald-950/25 py-1 pl-3"
                    >
                        <a class="block rounded-md py-2.5 pl-2 text-sm text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="{{ route('gallery.section', 'audio') }}" @click="mobile = false; galleryMobile = false">{{ __('messages.nav_media_audio') }}</a>
                        <a class="block rounded-md py-2.5 pl-2 text-sm text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="{{ route('gallery.section', 'photos') }}" @click="mobile = false; galleryMobile = false">{{ __('messages.nav_media_photos') }}</a>
                        <a class="block rounded-md py-2.5 pl-2 text-sm text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="{{ route('gallery.section', 'videos') }}" @click="mobile = false; galleryMobile = false">{{ __('messages.nav_media_videos') }}</a>
                        <a class="block rounded-md py-2.5 pl-2 text-sm text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="{{ route('gallery.section', 'presentation') }}" @click="mobile = false; galleryMobile = false">{{ __('messages.nav_media_presentation') }}</a>
                        <a class="block rounded-md py-2.5 pl-2 text-sm text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="{{ route('gallery.section', 'voice') }}" @click="mobile = false; galleryMobile = false">{{ __('messages.nav_media_voice') }}</a>
                    </div>
                </div>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/vacancies" @click="mobile = false">{{ __('messages.nav_vacancies') }}</a>
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/grm" @click="mobile = false">{{ __('messages.nav_grm') }}</a>
                @auth
                    <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="{{ route('admin.grm-complaints.index') }}" @click="mobile = false">Admin GRM inbox</a>
                @endauth
                <a class="block rounded-lg border-b border-white/10 py-3.5 pl-1 text-white transition duration-300 hover:bg-white/10 hover:text-irdc-nav-hover" href="/contact" @click="mobile = false">{{ __('messages.contact') }}</a>

                <a class="mt-2 inline-flex w-full items-center justify-center rounded-full bg-amber-500 px-4 py-2.5 font-bold text-slate-900 shadow-sm transition hover:bg-amber-400" href="/contact" @click="mobile = false">
                    {{ __('messages.home_get_involved') }}
                </a>

                @auth
                    <a class="mt-2 block rounded-lg py-3.5 pl-1 text-amber-200 transition hover:bg-white/10" href="{{ route('admin.home') }}" @click="mobile = false">
                        Admin
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>