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
            'message' => "A tarefa \"$task->name\" foi criada no projeto \"{$task->project->name}\"",
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
        $names = [];
        foreach($task->users as $user) {
            $names[] = $user->name;

            // Um log para cada usuário
            Log::create([
                'user_id' => $user->id,
                'message' => "$user->name completou a tarefa \"$task->name\"",
            ]);
        }

        $names = join(", ", $names);

        // Um log para a tarefa
        Log::create([
            'task_id' => $task->id,
            'project_id' => $task->project->id,
            'message' => "O(s) usuário(s) $names concluíram a tarefa \"$task->name\"",
        ]);
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
