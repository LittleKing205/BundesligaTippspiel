<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCurrentGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (is_null($request->user()->current_group_id)) {
                throw new Exception("No Group was set (TODO: route to group select)");
            } else {
                app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($request->user()->current_group_id);
            }
        }
        return $next($request);
    }
}
