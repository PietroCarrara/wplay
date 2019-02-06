<?php

namespace App\Observers;

use App\TaskUser;
use App\Task;
use App\User;
use App\Log;

class TaskUserObserver
{
    /**
     * Handle the task user "created" event.
     *
     * @param  \App\TaskUser  $taskUser
     * @return void
     */
    public function created(Task $task, User $user)
    {
        Log::create([
            'project_id' => $task->project_id,
            'task_id' => $task->id,
            'user_id' => $user->id,
            'message' => "$user->name começou a trabalhar na tarefa \"$task->name\"",
        ]);
    }

    /**
     * Handle the task user "updated" event.
     *
     * @param  \App\TaskUser  $taskUser
     * @return void
     */
    public function updated(TaskUser $taskUser)
    {
        //
    }

    /**
     * Handle the task user "deleted" event.
     *
     * @param  \App\TaskUser  $taskUser
     * @return void
     */
    public function deleted(TaskUser $taskUser)
    {
        //
    }

    /**
     * Handle the task user "restored" event.
     *
     * @param  \App\TaskUser  $taskUser
     * @return void
     */
    public function restored(TaskUser $taskUser)
    {
        //
    }

    /**
     * Handle the task user "force deleted" event.
     *
     * @param  \App\TaskUser  $taskUser
     * @return void
     */
    public function forceDeleted(TaskUser $taskUser)
    {
        //
    }
}
