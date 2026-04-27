<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'IRDCRP'))</title>
        <link rel="icon" type="image/png" href="{{ asset(config('irdcrp.logos.irdcrp')) }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        @stack('styles')
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container">
                <div class="public-navbar-logos me-2 me-lg-3" role="group" aria-label="Partner logos">
                    <a class="public-navbar-logos__item public-navbar-logos__item--brand text-decoration-none" href="{{ url('/') }}" title="{{ config('app.name', 'IRDCRP') }}">
                        <img src="{{ asset(config('irdcrp.logos.irdcrp')) }}" alt="{{ __('messages.logo_irdcrp_alt') }}" width="200" height="256">
                    </a>
                    <span class="public-navbar-logos__divider d-none d-sm-block" aria-hidden="true"></span>
                    <div class="public-navbar-logos__item public-navbar-logos__item--emblem d-none d-sm-flex" title="{{ __('messages.logo_emblem_alt') }}">
                        <img src="{{ asset(config('irdcrp.logos.emblem')) }}" alt="{{ __('messages.logo_emblem_alt') }}" width="48" height="48">
                    </div>
                    <span class="public-navbar-logos__divider d-none d-md-block" aria-hidden="true"></span>
                    <div class="public-navbar-logos__item public-navbar-logos__item--bank d-none d-md-flex" title="{{ __('messages.logo_world_bank_alt') }}">
                        <img src="{{ asset(config('irdcrp.logos.world_bank')) }}" alt="{{ __('messages.logo_world_bank_alt') }}" width="120" height="36">
                    </div>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#public-nav" aria-controls="public-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="public-nav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center text-lg-end">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/about">{{ __('messages.about') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/areas">{{ __('messages.nav_areas') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/components">{{ __('messages.nav_components') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/news">{{ __('messages.nav_news') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/procurement">{{ __('messages.nav_procurement') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/downloads">{{ __('messages.nav_downloads') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/gallery">{{ __('messages.nav_gallery') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/vacancies">{{ __('messages.nav_vacancies') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/grm">{{ __('messages.nav_grm') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/contact">{{ __('messages.contact') }}</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer class="text-center public-footer">
            <div class="container">
                <h5 class="h6 text-white-50 fw-semibold">Integrated Rurban Development and Climate Resilience Project</h5>
                <p class="mb-1 small text-white-50">{{ config('irdcrp.ministry_line_en', 'Ministry of Agriculture, Livestock, Land, and Irrigation') }}</p>
                <p class="mb-0 small text-white-50">© {{ date('Y') }} IRDCRP</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
</html>
