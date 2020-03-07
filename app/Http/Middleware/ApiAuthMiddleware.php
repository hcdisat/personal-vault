<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiAuthException;
use Closure;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ApiAuthException
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->check()) {
            throw new ApiAuthException();
        }

        return $next($request);
    }
}
