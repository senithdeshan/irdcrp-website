<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class ShowLaunchingSoon
{
    /**
     * Show the launch page for public frontend routes while keeping admin access open.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            ! config('irdcrp.launching_soon.enabled', true)
            || $this->hasLaunched()
            || $this->isSuperAdmin($request)
            || $this->shouldPassThrough($request)
        ) {
            return $next($request);
        }

        $timezone = config('irdcrp.launching_soon.timezone', 'Asia/Colombo');
        $launchAt = $this->launchAt();

        return response()
            ->view('errors.503', [
                'launchAt' => $launchAt,
                'serverNow' => Carbon::now($timezone),
                'launchTimezone' => $timezone,
            ], 503)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    private function hasLaunched(): bool
    {
        $launchAt = $this->launchAt();

        return $launchAt !== null && Carbon::now($launchAt->getTimezone())->greaterThanOrEqualTo($launchAt);
    }

    private function launchAt(): ?Carbon
    {
        $launchAt = config('irdcrp.launching_soon.launch_at', '2026-06-23 10:56:06');

        if (blank($launchAt)) {
            return null;
        }

        try {
            return Carbon::parse(
                $launchAt,
                config('irdcrp.launching_soon.timezone', 'Asia/Colombo')
            );
        } catch (\Throwable) {
            return null;
        }
    }

    private function shouldPassThrough(Request $request): bool
    {
        if ($request->is(
            'admin',
            'admin/*',
            'dashboard',
            'login',
            'logout',
            'forgot-password',
            'reset-password',
            'reset-password/*',
            'confirm-password',
            'verify-email',
            'verify-email/*',
            'email/verification-notification',
            'password',
            'lang',
            'lang/*',
            'build/*',
            'css/*',
            'js/*',
            'images/*',
            'storage/*',
            'favicon.ico',
            'robots.txt'
        )) {
            return true;
        }

        return false;
    }

    private function isSuperAdmin(Request $request): bool
    {
        return $request->user()?->email === config('irdcrp.super_admin.login');
    }
}
