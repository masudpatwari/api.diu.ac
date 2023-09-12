<?php

namespace App\Http\Middleware;

use App\ApiKey;
use App\Employee;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HostelAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        return $next($request);
    }
}
