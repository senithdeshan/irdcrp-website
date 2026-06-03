@php
    $inGallery = request()->is('gallery*');
    $inGrm = request()->is('grm*') || request()->is('admin/grm-complaints*');
    $inSupport = request()->is('contact') || request()->is('admin/support-messages*');
    $cmsPages = \Illuminate\Support\Facades\Schema::hasTable('pages')
        ? \App\Models\Page::query()->where('status', 'published')->orderBy('title')->get(['title', 'slug'])
        : collect();
    $pageUrl = function (string $slug, string $fallback) use ($cmsPages): string {
        $page = $cmsPages->firstWhere('slug', $slug);

        return $page ? route('page.show', $page) : $fallback;
    };
    $pathIs = fn (...$patterns) => request()->is(...$patterns);
    $inProject = $pathIs('about', 'components', 'areas', 'p/activities', 'p/organizational-structure');
    $inResources = $pathIs(
        'downloads*',
        'safeguards*',
        'p/reports',
        'p/safeguard',
        'p/social-management-plan-social-screening-report',
        'p/environment-management-plan-environment-screening-plan',
        'p/institutional-development',
    );
    $inSafeguard = $pathIs(
        'safeguards*',
        'p/safeguard',
        'p/social-management-plan-social-screening-report',
        'p/environment-management-plan-environment-screening-plan',
    );
    $inAnnouncements = $pathIs('procurement*', 'vacancies*', 'announcements/other*');
    $inFaq = $pathIs('faq');
    $projectItems = [
        ['label' => 'About Us', 'href' => url('/about'), 'active' => $pathIs('about')],
        ['label' => 'Components', 'href' => url('/components'), 'active' => $pathIs('components')],
        ['label' => 'Areas', 'href' => url('/areas'), 'active' => $pathIs('areas')],
        ['label' => 'Organizational Structure', 'href' => $pageUrl('organizational-structure', url('/#key-leaders')), 'active' => $pathIs('p/organizational-structure')],
    ];
    $resourceItems = [
        ['label' => 'Documents', 'href' => route('downloads.index'), 'active' => $pathIs('downloads*')],
        ['label' => 'Reports', 'href' => $pageUrl('reports', route('downloads.index')), 'active' => $pathIs('p/reports')],
        ['type' => 'submenu', 'label' => 'Safeguard', 'active' => $inSafeguard],
        ['label' => 'Institutional Development', 'href' => $pageUrl('institutional-development', route('downloads.index')), 'active' => $pathIs('p/institutional-development')],
    ];
    $safeguardItems = [
        [
            'label' => 'Social Management Plan & Social Screening Report',
            'href' => route('safeguards.show', 'social-management-plan-social-screening-report'),
            'active' => $pathIs('safeguards/social-management-plan-social-screening-report', 'p/social-management-plan-social-screening-report'),
        ],
        [
            'label' => 'Environment Management Plan & Environment Screening Plan',
            'href' => route('safeguards.show', 'environment-management-plan-environment-screening-plan'),
            'active' => $pathIs('safeguards/environment-management-plan-environment-screening-plan', 'p/environment-management-plan-environment-screening-plan'),
        ],
    ];
    $announcementItems = [
        ['label' => 'Procurement', 'href' => url('/procurement'), 'active' => $pathIs('procurement*')],
        ['label' => 'Vacancy', 'href' => route('vacancies.index'), 'active' => $pathIs('vacancies*')],
        ['label' => 'Other', 'href' => route('other-announcements.index'), 'active' => $pathIs('announcements/other*')],
    ];
    $navLink = 'irdc-nav-link relative inline-flex items-center whitespace-nowrap rounded-md px-1.5 py-2 text-[0.82rem] font-semibold tracking-wide font-display border-b-[3px] transition-colors duration-300 sm:px-2 sm:text-sm md:px-2 md:text-[0.86rem] lg:px-2 lg:text-[0.9rem] xl:px-2.5 xl:text-[0.98rem]';
    $active = 'border-[#0A3D62] bg-slate-50 text-[#0A3D62] font-bold shadow-sm hover:text-[#0A3D62]';
    $activeGalleryNav = 'border-[#0A3D62] bg-slate-50 text-[#0A3D62] font-bold shadow-sm hover:text-[#0A3D62]';
    $inactive = 'border-transparent text-slate-950 hover:border-slate-300 hover:bg-slate-100 hover:text-black';
@endphp

<div
    x-data="{ mobile: false, projectMobile: @js($inProject), resourcesMobile: @js($inResources), safeguardMobile: @js($inSafeguard), announcementsMobile: @js($inAnnouncements) }"
    class="sticky top-0 z-[9999]"
>
<header class="relative z-[1]">
    <div class="irdc-top-bar irdc-top-bar--slim border-b border-slate-200/80 bg-white/95">
        <div class="relative z-10 mx-auto max-w-7xl px-3 py-1.5 sm:px-5 sm:py-2 lg:px-8">
            <div class="irdc-top-bar__row flex w-full min-w-0 items-center justify-between gap-2 sm:gap-4">

                <div class="min-w-0 flex flex-1 justify-start overflow-hidden">
                    <div class="irdc-header-logo-parts" role="group" aria-label="{{ __('messages.logos_aria') }}">
                        <div class="irdc-header-logo-cell irdc-header-logo-cell--emblem" title="{{ __('messages.logo_emblem_alt') }}">
                            <img src="{{ asset(config('irdcrp.logos.emblem')) }}" alt="{{ __('messages.logo_emblem_alt') }}" width="48" height="48" loading="eager" decoding="async">
                        </div>

                        <a href="{{ url('/') }}" class="irdc-header-logo-cell irdc-header-logo-cell--irdcrp" title="{{ config('app.name', 'IRDCRP') }}">
                            <img src="{{ asset(config('irdcrp.logos.irdcrp')) }}" alt="{{ __('messages.logo_irdcrp_alt') }}" width="48" height="61" loading="eager" decoding="async">
                        </a>

                        <div class="irdc-header-logo-cell irdc-header-logo-cell--worldbank" title="{{ __('messages.logo_world_bank_alt') }}">
                            <img src="{{ asset(config('irdcrp.logos.world_bank')) }}" alt="{{ __('messages.logo_world_bank_alt') }}" width="160" height="53" loading="eager" decoding="async">
                        </div>
                    </div>
                </div>

                <div class="irdc-header-tools irdc-header-tools--slim flex shrink-0 min-w-0 items-center justify-end gap-1.5 sm:gap-2">
                    <div class="irdc-header-tools__cluster flex min-w-0 max-w-full flex-nowrap items-center justify-end gap-1 sm:gap-1.5">

                        <div class="inline-flex items-center gap-0.5 rounded-full border border-emerald-200/80 bg-white p-0.5 shadow-sm" aria-label="{{ __('messages.header_social_aria') }}">
                            <a class="irdc-header-social" href="{{ $socialLinks['facebook'] ?? config('irdcrp.social.facebook') }}" rel="noopener noreferrer" target="_blank" title="Facebook">
                                <x-social-icon name="facebook" class="h-4 w-4" />
                            </a>
                            <a class="irdc-header-social" href="{{ $socialLinks['youtube'] ?? config('irdcrp.social.youtube') }}" rel="noopener noreferrer" target="_blank" title="YouTube">
                                <x-social-icon name="youtube" class="h-4 w-4" />
                            </a>
                            <a class="irdc-header-social" href="{{ $socialLinks['twitter'] ?? config('irdcrp.social.twitter') }}" rel="noopener noreferrer" target="_blank" title="X">
                                <x-social-icon name="x" class="h-4 w-4" />
                            </a>
                            <a class="irdc-header-social" href="{{ $socialLinks['linkedin'] ?? config('irdcrp.social.linkedin') }}" rel="noopener noreferrer" target="_blank" title="LinkedIn">
                                <x-social-icon name="linkedin" class="h-4 w-4" />
                            </a>
                            <a class="irdc-header-social" href="{{ $socialLinks['instagram'] ?? config('irdcrp.social.instagram') }}" rel="noopener noreferrer" target="_blank" title="Instagram">
                                <x-social-icon name="instagram" class="h-4 w-4" />
                            </a>
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

                    </div>
                </div>

            </div>
        </div>
    </div>

    </header>

    <div class="irdc-main-nav relative z-[2] overflow-visible border-b border-slate-200 bg-white text-slate-950 shadow-md shadow-slate-900/10 ring-1 ring-slate-900/5">
        <div class="mx-auto max-w-[90rem] overflow-visible px-3 py-1 sm:px-5 lg:px-6 xl:px-8">
            <div class="flex w-full min-h-[3.25rem] items-center justify-end gap-2 overflow-visible md:min-h-[3.35rem] md:justify-between">

                <nav id="main-nav-desktop" class="irdc-main-nav__links hidden w-full min-w-0 flex-1 flex-wrap items-center justify-center gap-x-1 gap-y-1 overflow-visible py-0 lg:flex xl:gap-x-1.5" aria-label="{{ __('messages.nav_primary_aria') }}">
                    <a href="{{ url('/') }}" class="{{ $navLink }} {{ request()->is('/') ? $active : $inactive }}">Home</a>

                    <x-dropdown align="left" width="w-max max-w-[18rem]" panelMinWidth="" panelRounded="rounded-lg" panelExtraClass="shadow-[0_6px_18px_rgba(0,0,0,0.12)]" contentClasses="bg-white py-1 [&>a]:!px-3 [&>a]:!py-2 [&>a]:!text-sm [&>a]:!leading-snug [&>a:hover]:!pl-4">
                        <x-slot name="trigger">
                            <button type="button" class="group {{ $navLink }} {{ $inProject ? $activeGalleryNav : $inactive }} !inline-flex max-w-max items-center gap-1" aria-haspopup="true">
                                <span class="whitespace-nowrap">The Project</span>
                                <span class="inline-flex shrink-0 text-slate-700 transition-colors duration-300 group-hover:text-black" aria-hidden="true">
                                    <svg width="11" height="11" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-[11px] w-[11px] max-h-[11px] max-w-[11px]">
                                        <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                                    </svg>
                                </span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @foreach($projectItems as $item)
                                <x-dropdown-link href="{{ $item['href'] }}" @class(['font-bold text-[#0A3D62]' => $item['active']])>{{ $item['label'] }}</x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="left" width="w-max max-w-[30rem]" panelMinWidth="" panelRounded="rounded-lg" panelExtraClass="shadow-[0_6px_18px_rgba(0,0,0,0.12)]" contentOverflow="overflow-visible" contentClasses="bg-white py-1 [&>a]:!px-3 [&>a]:!py-2 [&>a]:!text-sm [&>a]:!leading-snug [&>a:hover]:!pl-4">
                        <x-slot name="trigger">
                            <button type="button" class="group {{ $navLink }} {{ $inResources ? $activeGalleryNav : $inactive }} !inline-flex max-w-max items-center gap-1" aria-haspopup="true">
                                <span class="whitespace-nowrap">Resources</span>
                                <span class="inline-flex shrink-0 text-slate-700 transition-colors duration-300 group-hover:text-black" aria-hidden="true">
                                    <svg width="11" height="11" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-[11px] w-[11px] max-h-[11px] max-w-[11px]">
                                        <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                                    </svg>
                                </span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @foreach($resourceItems as $item)
                                @if(($item['type'] ?? null) === 'submenu')
                                    <div
                                        x-data="{ safeguardOpen: @js($item['active']) }"
                                        class="group/safeguard relative border-y border-slate-100 bg-slate-50/60"
                                        @click.stop
                                    >
                                        <button
                                            type="button"
                                            class="flex w-full items-center justify-between gap-3 px-3 py-2 text-start text-sm font-semibold leading-snug text-gray-800 transition hover:bg-white hover:pl-4 {{ $item['active'] ? 'font-bold text-[#0A3D62]' : '' }}"
                                            aria-haspopup="true"
                                            @click="safeguardOpen = ! safeguardOpen"
                                            :aria-expanded="safeguardOpen"
                                        >
                                            <span>{{ $item['label'] }}</span>
                                            <span
                                                class="text-slate-500 transition-transform group-hover/safeguard:translate-x-0.5"
                                                :class="safeguardOpen ? 'translate-x-0.5 text-[#0A3D62]' : ''"
                                                aria-hidden="true"
                                            >
                                                <svg width="13" height="13" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 3L7.5 6L4.5 9" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </span>
                                        </button>
                                        <div
                                            class="invisible absolute left-[calc(100%+0.35rem)] top-0 z-[10001] w-[24rem] rounded-lg border border-slate-100 bg-white py-1 opacity-0 shadow-[0_10px_25px_rgba(0,0,0,0.14)] ring-1 ring-black/5 transition group-hover/safeguard:visible group-hover/safeguard:opacity-100 group-focus-within/safeguard:visible group-focus-within/safeguard:opacity-100"
                                            :class="safeguardOpen ? '!visible !opacity-100' : ''"
                                        >
                                            @foreach($safeguardItems as $safeguardItem)
                                                <x-dropdown-link
                                                    href="{{ $safeguardItem['href'] }}"
                                                    @class([
                                                        'font-bold text-[#0A3D62]' => $safeguardItem['active'],
                                                        '!pl-6 text-[0.82rem]',
                                                    ])
                                                >
                                                    {{ $safeguardItem['label'] }}
                                                </x-dropdown-link>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <x-dropdown-link
                                        href="{{ $item['href'] }}"
                                        @class([
                                            'font-bold text-[#0A3D62]' => $item['active'],
                                        ])
                                    >
                                        {{ $item['label'] }}
                                    </x-dropdown-link>
                                @endif
                            @endforeach
                        </x-slot>
                    </x-dropdown>

                    <a href="{{ route('programmes.index') }}" class="{{ $navLink }} {{ request()->is('programmes*') ? $active : $inactive }}">Programmes</a>
                    <a href="{{ route('news.index') }}" class="{{ $navLink }} {{ request()->is('news*') ? $active : $inactive }}">News &amp; Events</a>
                    <a href="{{ route('gallery.index') }}" class="{{ $navLink }} {{ $inGallery ? $active : $inactive }}">Gallery</a>

                    <x-dropdown align="left" width="w-max max-w-[13rem]" panelMinWidth="" panelRounded="rounded-lg" panelExtraClass="shadow-[0_6px_18px_rgba(0,0,0,0.12)]" contentClasses="bg-white py-1 [&>a]:!px-3 [&>a]:!py-2 [&>a]:!text-sm [&>a]:!leading-snug [&>a:hover]:!pl-4">
                        <x-slot name="trigger">
                            <button type="button" class="group {{ $navLink }} {{ $inAnnouncements ? $activeGalleryNav : $inactive }} !inline-flex max-w-max items-center gap-1" aria-haspopup="true">
                                <span class="whitespace-nowrap">Announcements</span>
                                <span class="inline-flex shrink-0 text-slate-700 transition-colors duration-300 group-hover:text-black" aria-hidden="true">
                                    <svg width="11" height="11" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-[11px] w-[11px] max-h-[11px] max-w-[11px]">
                                        <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                                    </svg>
                                </span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @foreach($announcementItems as $item)
                                <x-dropdown-link href="{{ $item['href'] }}" @class(['font-bold text-[#0A3D62]' => $item['active']])>{{ $item['label'] }}</x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>

                    <a href="{{ url('/grm') }}" class="{{ $navLink }} {{ $inGrm ? $active : $inactive }}">GRM</a>
                    <a href="{{ url('/faq') }}" class="{{ $navLink }} {{ $inFaq ? $active : $inactive }}">FAQ</a>
                    <a href="{{ url('/contact') }}" class="{{ $navLink }} {{ $inSupport ? $active : $inactive }}">Contact Us</a>

                    @auth
                        <a href="{{ route('admin.home') }}" class="{{ $navLink }} {{ request()->is('admin*') ? $active : $inactive }}">Admin</a>
                    @endauth
                </nav>

                <button
                    type="button"
                    id="main-nav-toggle"
                    @click="mobile = ! mobile"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg text-slate-950 transition hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400 lg:hidden"
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
            class="lg:hidden max-h-[min(75vh,32rem)] overflow-y-auto border-t border-slate-200 bg-white shadow-inner backdrop-blur-sm"
            role="navigation"
            aria-label="{{ __('messages.nav_primary_aria') }}"
        >
            <div class="mx-auto max-w-7xl space-y-0 px-3 pb-5 pt-1 text-base font-semibold font-display sm:px-5 sm:text-lg lg:px-8">
                <a class="block rounded-lg border-b border-slate-200 py-3.5 pl-1 transition duration-300 hover:bg-slate-100" href="{{ url('/') }}" @click="mobile = false">Home</a>

                <div class="border-b border-slate-200">
                    <button type="button" class="flex w-full items-center justify-between rounded-lg py-3.5 pl-1 pr-1 text-start transition hover:bg-slate-100" @click="projectMobile = ! projectMobile" :aria-expanded="projectMobile">
                        <span class="{{ $inProject ? 'font-bold text-[#0A3D62]' : '' }}">The Project</span>
                        <span class="inline-flex shrink-0 text-slate-500 transition-transform duration-200" :class="projectMobile ? 'rotate-180' : ''" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-3.5 w-3.5 max-h-[14px] max-w-[14px]"><path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" /></svg>
                        </span>
                    </button>
                    <div x-show="projectMobile" x-cloak class="space-y-0 border-t border-slate-200 bg-slate-50 py-1 pl-3">
                        @foreach($projectItems as $item)
                            <a class="block rounded-md py-2.5 pl-2 text-sm transition duration-300 hover:bg-white {{ $item['active'] ? 'font-bold text-[#0A3D62]' : 'text-slate-700' }}" href="{{ $item['href'] }}" @click="mobile = false; projectMobile = false">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="border-b border-slate-200">
                    <button type="button" class="flex w-full items-center justify-between rounded-lg py-3.5 pl-1 pr-1 text-start transition hover:bg-slate-100" @click="resourcesMobile = ! resourcesMobile" :aria-expanded="resourcesMobile">
                        <span class="{{ $inResources ? 'font-bold text-[#0A3D62]' : '' }}">Resources</span>
                        <span class="inline-flex shrink-0 text-slate-500 transition-transform duration-200" :class="resourcesMobile ? 'rotate-180' : ''" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-3.5 w-3.5 max-h-[14px] max-w-[14px]"><path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" /></svg>
                        </span>
                    </button>
                    <div x-show="resourcesMobile" x-cloak class="space-y-0 border-t border-slate-200 bg-slate-50 py-1 pl-3">
                        @foreach($resourceItems as $item)
                            @if(($item['type'] ?? null) === 'submenu')
                                <div class="border-b border-slate-200/70">
                                    <button
                                        type="button"
                                        class="flex w-full items-center justify-between rounded-md py-2.5 pl-2 pr-2 text-start text-sm transition duration-300 hover:bg-white {{ $item['active'] ? 'font-bold text-[#0A3D62]' : 'text-slate-700' }}"
                                        @click="safeguardMobile = ! safeguardMobile"
                                        :aria-expanded="safeguardMobile"
                                    >
                                        <span>{{ $item['label'] }}</span>
                                        <span class="inline-flex shrink-0 text-slate-500 transition-transform duration-200" :class="safeguardMobile ? 'rotate-180' : ''" aria-hidden="true">
                                            <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-3.5 w-3.5 max-h-[14px] max-w-[14px]"><path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" /></svg>
                                        </span>
                                    </button>
                                    <div x-show="safeguardMobile" x-cloak class="border-t border-slate-200 bg-white/70 py-1 pl-3">
                                        @foreach($safeguardItems as $safeguardItem)
                                            <a
                                                class="block rounded-md py-2.5 pl-3 text-sm transition duration-300 hover:bg-white {{ $safeguardItem['active'] ? 'font-bold text-[#0A3D62]' : 'text-slate-700' }}"
                                                href="{{ $safeguardItem['href'] }}"
                                                @click="mobile = false; resourcesMobile = false; safeguardMobile = false"
                                            >
                                                {{ $safeguardItem['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a
                                    class="block rounded-md py-2.5 pl-2 text-sm transition duration-300 hover:bg-white {{ $item['active'] ? 'font-bold text-[#0A3D62]' : 'text-slate-700' }}"
                                    href="{{ $item['href'] }}"
                                    @click="mobile = false; resourcesMobile = false"
                                >
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <a class="block rounded-lg border-b border-slate-200 py-3.5 pl-1 transition duration-300 hover:bg-slate-100 {{ request()->is('programmes*') ? 'font-bold text-[#0A3D62]' : '' }}" href="{{ route('programmes.index') }}" @click="mobile = false">Programmes</a>
                <a class="block rounded-lg border-b border-slate-200 py-3.5 pl-1 transition duration-300 hover:bg-slate-100" href="{{ route('news.index') }}" @click="mobile = false">News &amp; Events</a>
                <a class="block rounded-lg border-b border-slate-200 py-3.5 pl-1 transition duration-300 hover:bg-slate-100" href="{{ route('gallery.index') }}" @click="mobile = false">Gallery</a>

                <div class="border-b border-slate-200">
                    <button type="button" class="flex w-full items-center justify-between rounded-lg py-3.5 pl-1 pr-1 text-start transition hover:bg-slate-100" @click="announcementsMobile = ! announcementsMobile" :aria-expanded="announcementsMobile">
                        <span class="{{ $inAnnouncements ? 'font-bold text-[#0A3D62]' : '' }}">Announcements</span>
                        <span class="inline-flex shrink-0 text-slate-500 transition-transform duration-200" :class="announcementsMobile ? 'rotate-180' : ''" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block h-3.5 w-3.5 max-h-[14px] max-w-[14px]"><path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" /></svg>
                        </span>
                    </button>
                    <div x-show="announcementsMobile" x-cloak class="space-y-0 border-t border-slate-200 bg-slate-50 py-1 pl-3">
                        @foreach($announcementItems as $item)
                            <a class="block rounded-md py-2.5 pl-2 text-sm transition duration-300 hover:bg-white {{ $item['active'] ? 'font-bold text-[#0A3D62]' : 'text-slate-700' }}" href="{{ $item['href'] }}" @click="mobile = false; announcementsMobile = false">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>

                <a class="block rounded-lg border-b border-slate-200 py-3.5 pl-1 transition duration-300 hover:bg-slate-100" href="/grm" @click="mobile = false">GRM</a>
                <a class="block rounded-lg border-b border-slate-200 py-3.5 pl-1 transition duration-300 hover:bg-slate-100" href="/faq" @click="mobile = false">FAQ</a>
                <a class="block rounded-lg border-b border-slate-200 py-3.5 pl-1 transition duration-300 hover:bg-slate-100" href="/contact" @click="mobile = false">Contact Us</a>

                @auth
                    <a class="mt-2 block rounded-lg py-3.5 pl-1 font-bold text-[#0A3D62] transition hover:bg-slate-100" href="{{ route('admin.home') }}" @click="mobile = false">Admin</a>
                @endauth
            </div>
        </div>
    </div>
</div>
