<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
            || $this->isSuperAdmin($request)
            || $this->shouldPassThrough($request)
        ) {
            return $next($request);
        }

        return response()->view('errors.503', [], 503);
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
