<?php

namespace EmberGrep\Http\Middleware\Exceptions;

use Closure;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class ValidationHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $response = $next($request);

            return $response;
        } catch (ValidationException $e) {
            return new JsonResponse('Foo', 200);
        }
    }
}
