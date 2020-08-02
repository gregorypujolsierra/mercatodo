<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(
            'list-users',
            function ($user) {
                return $user->hasAnyRoles(['admin', 'staff']);
            }
        );

        Gate::define(
            'manage-users',
            function ($user) {
                return $user->hasRole('admin');
            }
        );

        /**
         * @todo Replace field 'is_enabled' to 'user_enabled'
        */
        Gate::define(
            'user-enabled',
            function ($user) {
                return $user->enabled;
            }
        );

        Gate::define(
            'list-products',
            function ($user) {
                return $user->hasAnyRoles(['admin', 'staff']);
            }
        );

        Gate::define(
            'manage-products',
            function ($user) {
                return $user->hasRole('admin');
            }
        );
    }
}
