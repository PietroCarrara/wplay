<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use \App\Project;
use \App\Task;

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
            return $user->roles == 'admin' || $proj->users->contains($user);;
        });

        Gate::define('comment-task', function($user, Task $task) {
            return !$task->trashed() && $task->users->contains($user);
        });

        Gate::define('manage-users', function($user) {
            return $user->role == 'admin';
        });
    }
}
