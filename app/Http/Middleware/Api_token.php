<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Api_token
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
        $user = User::firstOrFail($request->header('user_id'));

        if($user->api_token == $request->header('api_token')){
            return $next($request);
        } else {
            return response('Unauthorized.', 401);
        }
    }
}
