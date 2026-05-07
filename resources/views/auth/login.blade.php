<x-guest-layout>
    <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] p-6 sm:p-8 lg:p-10">
        <div class="relative overflow-hidden rounded-[1.75rem] bg-slate-950 px-8 py-10 text-white shadow-2xl shadow-slate-950/40">
            <div class="absolute -top-10 -right-10 h-44 w-44 rounded-full bg-emerald-500/20 blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 h-56 w-56 rounded-full bg-cyan-500/20 blur-3xl"></div>
            <div class="relative z-10">
                <span class="inline-block rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-200">Secure sign in</span>
                <h1 class="mt-6 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Welcome back.</h1>
                <p class="mt-4 text-sm leading-7 text-slate-300">Access your dashboard with a refreshed, modern login experience designed for speed and clarity.</p>

                <div class="mt-10 grid gap-5 rounded-[1.5rem] border border-white/10 bg-white/5 p-6 text-sm text-slate-200 shadow-lg shadow-slate-950/20">
                    <div>
                        <p class="font-semibold text-white">Why sign in?</p>
                        <p class="mt-2 text-slate-300">Secure your account with encrypted authentication, remember me support, and a clean interface.</p>
                    </div>
                    <div class="space-y-2 text-slate-300">
                        <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Fast access to your dashboard</p>
                        <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Built for clarity and responsiveness</p>
                        <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Modern, professional design</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-[1.75rem] bg-white px-6 py-8 shadow-xl ring-1 ring-slate-200/80 sm:px-10">
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-slate-900">Sign in to your account</h2>
                <p class="mt-2 text-sm text-slate-500">Enter your details below to continue.</p>
            </div>

            <x-auth-session-status class="mb-5" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Password')" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <x-text-input id="password" class="mt-2" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center gap-3">
                    <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" name="remember">
                        <span>{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div>
                    <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                New here? <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Create an account</a>
            </p>
        </div>
    </div>
</x-guest-layout>
