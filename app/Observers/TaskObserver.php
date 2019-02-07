<?php

namespace App\Observers;

use App\Task;
use App\Log;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        Log::create([
            'task_id' => $task->id,
            'project_id' => $task->project_id,
            'message' => "A tarefa \":task:\" foi criada no projeto \":project:\"",
        ]);
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $log = Log::create([
            'task_id' => $task->id,
            // 'project_id' => $task->project->id,
            'message' => "O(s) usuário(s) :users: concluíram a tarefa \":task:\"",
        ]);

        foreach($task->users as $user) {
            $log->users()->save($user);
        }
    }

    /**
     * Handle the task "restored" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
