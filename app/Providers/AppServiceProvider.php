<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\User::observe(\App\Observers\UserObserver::class);
        \App\Project::observe(\App\Observers\ProjectObserver::class);
        \App\Task::observe(\App\Observers\TaskObserver::class);
        \App\Comment::observe(\App\Observers\CommentObserver::class);
        \App\ProjectUser::observe(\App\Observers\ProjectUserObserver::class);
        \App\TaskUser::observe(\App\Observers\TaskUserObserver::class);
        \App\TaskUserVote::observe(\App\Observers\TaskVotesObserver::class);
    }
}
