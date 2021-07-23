<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckUserToken
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
            config()->set( 'auth.defaults.guard', 'user-api' );
            \Config::set('jwt.user', 'App\Models\User'); 
            \Config::set('auth.providers.users.model', \App\Models\User::class);
            $user = null;
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json('INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json('EXPIRED_TOKEN');
            } else {
                return response()->json('TOKEN_NOTFOUND1');
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json('INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json('EXPIRED_TOKEN');
            } else {
                return response()->json('TOKEN_NOTFOUND2');
            }
        }

        if (!$user)
        return response()->json("uthenticated");
        return $next($request);
    }
}