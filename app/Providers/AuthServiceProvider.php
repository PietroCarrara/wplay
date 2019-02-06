<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use \App\Project;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-projects', function($user) {
            return $user->role == 'admin';
        });

        Gate::define('manage-tasks', function($user, Project $proj) {
            if ($user->roles == 'admin') {
                return true;
            } else {
                return $proj->users->contains($user);
            }
        });
    }
}
