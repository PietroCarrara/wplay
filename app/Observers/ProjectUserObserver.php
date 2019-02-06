<?php

namespace App\Observers;

use App\ProjectUser;
use \App\Log;
use \App\User;
use \App\Project;

class ProjectUserObserver
{
    /**
     * Handle the project user "created" event.
     *
     * @param  \App\ProjectUser  $projectUser
     * @return void
     */
    public function created(Project $proj, User $user)
    {
        Log::create([
            'user_id' => $user->id,
            'project_id' => $proj->id,
            'message' => "$user->name se juntou ao projeto \"$proj->name\"",
        ]);
    }

    /**
     * Handle the project user "updated" event.
     *
     * @param  \App\ProjectUser  $projectUser
     * @return void
     */
    public function updated(ProjectUser $projectUser)
    {
        //
    }

    /**
     * Handle the project user "deleted" event.
     *
     * @param  \App\ProjectUser  $projectUser
     * @return void
     */
    public function deleted(Project $proj, User $user)
    {
        Log::create([
            'user_id' => $user->id,
            'project_id' => $proj->id,
            'message' => "$user->name deixou o projeto \"$proj->name\"",
        ]);
    }

    /**
     * Handle the project user "restored" event.
     *
     * @param  \App\ProjectUser  $projectUser
     * @return void
     */
    public function restored(ProjectUser $projectUser)
    {
        //
    }

    /**
     * Handle the project user "force deleted" event.
     *
     * @param  \App\ProjectUser  $projectUser
     * @return void
     */
    public function forceDeleted(ProjectUser $projectUser)
    {
        //
    }
}