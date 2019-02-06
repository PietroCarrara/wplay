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
            if ($user->roles == 'admin') {
                return true;
            } else {
                return $proj->users->contains($user);
            }
        });

        Gate::define('comment-task', function($user, Task $task) {
            return $task->users->contains($user);
        });
    }
}
