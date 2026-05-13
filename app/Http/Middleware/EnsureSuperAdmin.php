<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    /**
     * Allow admin maintenance pages only for the locked super-admin account.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->email === config('irdcrp.super_admin.login')) {
            return $next($request);
        }

        abort(403);
    }
}
