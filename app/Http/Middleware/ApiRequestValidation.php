<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiAuthException;
use App\Exceptions\ApiRequestValidationException;
use App\Http\Requests\V1\Validation\RequestValidator;
use Closure;
use Illuminate\Http\Request;

class ApiRequestValidation
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ApiAuthException|ApiRequestValidationException
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = new RequestValidator($request);
        $validator->validateByRouteName();
        return $next($request);
    }
}
