<?php

namespace App\Observers;

use App\TaskUserVote;
use App\Log;
use App\User;
use App\Task;

class TaskVotesObserver
{
    /**
     * Handle the task user vote "created" event.
     *
     * @param  \App\TaskUserVote  $taskUserVote
     * @return void
     */
    public function created(Task $task, User $user)
    {
        $log = Log::create([
            'task_id' => $task->id,
            'project_id' => $task->project->id,
            'message' => ':users: votou para concluir a tarefa :task:.',
        ]);

        $log->users()->save($user);

        // Se metade ou mais dos integrantes votou para que a tarefa fosse concluída,
        // conclua a tarefa
        if ($task->votes()->count() >= $task->users()->count()/2 && $task->users()->count() > 0) {
            $task->delete();
        }
    }

    /**
     * Handle the task user vote "updated" event.
     *
     * @param  \App\TaskUserVote  $taskUserVote
     * @return void
     */
    public function updated(TaskUserVote $taskUserVote)
    {
        //
    }

    /**
     * Handle the task user vote "deleted" event.
     *
     * @param  \App\TaskUserVote  $taskUserVote
     * @return void
     */
    public function deleted(Task $task, User $user)
    {
        $log = Log::create([
            'task_id' => $task->id,
            'project_id' => $task->project->id,
            'message' => ':users: revogou seu voto para concluir a tarefa :task:.',
        ]);

        $log->users()->save($user);
    }

    /**
     * Handle the task user vote "restored" event.
     *
     * @param  \App\TaskUserVote  $taskUserVote
     * @return void
     */
    public function restored(TaskUserVote $taskUserVote)
    {
        //
    }

    /**
     * Handle the task user vote "force deleted" event.
     *
     * @param  \App\TaskUserVote  $taskUserVote
     * @return void
     */
    public function forceDeleted(TaskUserVote $taskUserVote)
    {
        //
    }
}
