<?php

use Faker\Generator as Faker;

function _comment_factory_(Faker $faker) {
    
    $proj = App\Project::All()->random();

    $tasks = $proj->tasks()->get();
    $users = $proj->users()->get();

    // Se o projeto não tem ninguém ou nenhuma tarefa,
    // procure outro projeto
    if ($tasks->count() <= 0 || $users->count() <= 0) {
        return _comment_factory_($faker);   
    }

    $task = $tasks->random();
    $user = $users->random();
    
    return [
        'contents' => $faker->sentence(),
        'user_id' => $user->id,
        'task_id' => $task->id,
    ];

}

$factory->define(App\Comment::class, '_comment_factory_');
