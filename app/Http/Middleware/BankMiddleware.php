<?php

namespace App\Http\Middleware;

use Closure;

class BankMiddleware
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

         $token = trim($request->get('token'));
        //   $checkIp = $request->ip();         


        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }
        $checkToken = 'Kyxufto3M1W8ySwrYBFQLAMKBqkbP35uCGBPzKVS2pv1ymiFxGm1xcODuQkC';
        if($checkToken === $token){
            return $next($request);

        } else{
            return response()->json([
                'error' => 'Token not found.'
            ], 401);

        }

        
    }
}
