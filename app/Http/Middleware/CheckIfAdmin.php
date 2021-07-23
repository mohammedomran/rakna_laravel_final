<?php

namespace App\Http\Middleware;
use App\Models\Admin;
use Auth;

use Closure;

class CheckIfAdmin
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
        
        $admin = Admin::find(Auth::guard('admin-api')->user()->id);
        if($admin->role!="admin") {
            return "sorry, this end point is limited for admins only";
        }

        return $next($request);
    }
}
