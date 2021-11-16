<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCurrentGroup
{
    protected $exeptRoutes = [
        'group/switch',
        'group/new',
        'group/new/create',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->path(), $this->exeptRoutes))
            return $next($request);

        if (Auth::check()) {
            if (is_null($request->user()->current_group_id)) {
                //throw new Exception("No Group was set (TODO: route to group select)");
                return redirect(route('group.new.show'));
            } else {
                app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($request->user()->current_group_id);
            }
        }
        return $next($request);
    }
}
