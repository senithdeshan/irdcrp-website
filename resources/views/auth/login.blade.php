<x-guest-layout>
    <div class="irdc-login-shell">
        <section class="irdc-login-panel">
            <div class="irdc-login-panel__logos" aria-label="Project partners">
                <span><img src="{{ asset(config('irdcrp.logos.emblem')) }}" alt="Government of Sri Lanka"></span>
                <span><img src="{{ asset(config('irdcrp.logos.irdcrp')) }}" alt="IRDCRP"></span>
                <span class="irdc-login-panel__bank"><img src="{{ asset(config('irdcrp.logos.world_bank')) }}" alt="The World Bank"></span>
            </div>

            <p class="irdc-login-panel__eyebrow">Secure administration</p>
            <h1 class="irdc-login-panel__title">IRDCRP content management</h1>
            <p class="irdc-login-panel__lead">
                Sign in to manage project updates, programmes, notices, gallery content, impact figures, and public information.
            </p>

            <div class="irdc-login-panel__features">
                <div>
                    <span>01</span>
                    <p>Publish verified project information</p>
                </div>
                <div>
                    <span>02</span>
                    <p>Update public website sections quickly</p>
                </div>
                <div>
                    <span>03</span>
                    <p>Keep notices, media, and metrics current</p>
                </div>
            </div>
        </section>

        <section class="irdc-login-card">
            <div class="irdc-login-card__head">
                <p>Admin login</p>
                <h2>Welcome back</h2>
                <span>Use your authorized account to continue.</span>
            </div>

            <x-auth-session-status class="mb-5" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="irdc-login-form">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email address')" />
                    <x-text-input id="email" class="irdc-login-input mt-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <div class="flex items-center justify-between gap-3">
                        <x-input-label for="password" :value="__('Password')" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="irdc-login-forgot">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <x-text-input id="password" class="irdc-login-input mt-2" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="irdc-login-options">
                    <label for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>{{ __('Remember me') }}</span>
                    </label>
                </div>

                <x-primary-button class="irdc-login-submit">
                    {{ __('Log in') }}
                </x-primary-button>
            </form>

            <div class="irdc-login-card__foot">
                <a href="{{ url('/') }}">Return to website</a>
                @if (Route::has('register'))
                    <span aria-hidden="true">·</span>
                    <a href="{{ route('register') }}">Create account</a>
                @endif
            </div>
        </section>
    </div>
</x-guest-layout>
