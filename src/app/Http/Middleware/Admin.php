<?php

namespace App\Http\Middleware;

use App\Exceptions\Access\AccessDenied;
use Closure;

class Admin
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws AccessDenied
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user_is_admin)
            throw new AccessDenied();

        return $next($request);
    }
}
