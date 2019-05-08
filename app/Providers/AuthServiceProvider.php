<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Role' => 'App\Models\Policies\RolePolicy',
        // 'App\Models\User' => 'App\Models\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::resource('roles', 'App\Policies\RolePolicy');
        Gate::resource('users', 'App\Policies\UserPolicy');

        // Gate::guessPolicyNamesUsing(
        //     function ($modelClass) {
        //         $policyName = class_basename($modelClass);

        //         return "App\\Policies\\{$policyName}";
        //     }
        // );

        // Gate::define('list.roles', 'App\Models\Policies\RolePolicy@listRoles');
        // Gate::define('create.roles', 'App\Policies\RolePolicy@createRoles');
        // Gate::define('update.roles', 'App\Policies\RolePolicy@updateRoles');
        // Gate::define('delete.roles', 'App\Policies\RolePolicy@deleteRoles');

        // Gate::define('list.roles', 'App\Policies\RolePolicy@listRoles');
        // Gate::define('create.roles', 'App\Policies\RolePolicy@createRoles');
        // Gate::define('update.roles', 'App\Policies\RolePolicy@updateRoles');
        // Gate::define('delete.roles', 'App\Policies\RolePolicy@deleteRoles');

        
        Passport::tokensExpireIn(now()->addDays(30));
        Passport::refreshTokensExpireIn(now()->addDays(60));
        Passport::tokensCan(
            [
                'access_frontend' => 'Frontend access only',
                'access_backend'  => 'Backend access only',
            ]
        );
    }
}
