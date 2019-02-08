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
     */
    public function created(Task $task, User $user)
    {
        $log = Log::create([
            'project_id' => $task->project_id,
            'task_id' => $task->id,
            'message' => ":users: começou a trabalhar na tarefa \":task:\"",
        ]);

        $log->users()->save($user);
    }

    /**
     * Handle the task user "updated" event.
     *
     */
    public function updated(Task $task, User $user)
    {
    }

    /**
     * Handle the task user "deleted" event.
     *
     */
    public function deleted(Task $task, User $user)
    {
        $log = Log::create([
            'project_id' => $task->project_id,
            'task_id' => $task->id,
            'message' => ":users: deixou a tarefa \":task:\"",
        ]);
    
        $log->users()->save($user);
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
