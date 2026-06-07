<?php

namespace App\Http\Middleware;

use App\Support\SiteModules;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteModuleEnabled
{
    /**
     * Block public URLs for disabled site modules (admin routes always pass through).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is(
            'admin',
            'admin/*',
            'login',
            'logout',
            'dashboard',
            'build/*',
            'storage/*',
            'images/*',
        )) {
            return $next($request);
        }

        $modules = app(SiteModules::class);

        foreach ($modules->disabledPublicPatterns() as $pattern) {
            if ($request->is($pattern)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
