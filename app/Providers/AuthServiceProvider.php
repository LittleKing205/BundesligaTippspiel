<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('group-admin', function(User $user) {
            return ($user->id == $user->currentGroup->owner->id);
        });

        Gate::before(function(User $user, $abtility) {
            if(Str::startsWith($abtility, "dev."))
                return null;
            return $user->id == $user->currentGroup->owner->id ? true : null;
        });
    }
}
