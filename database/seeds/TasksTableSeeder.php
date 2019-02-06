<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Task::class, 50)->create()->each(function ($task) {
            $users = $task->project->users()->get();
            $users = $users->shuffle();

            // Adicionar trabalhadores aleatórios nas tarefas
            for ($i = 0; $i < 2 && $i < $users->count(); $i++) {
                $task->users()->save($users[$i]);
            }
        });
    }
}
