<?php

use Faker\Generator as Faker;

function _comment_factory_(Faker $faker) {

    $proj = App\Project::All()->random();

    $users = $proj->users()->get();

    // Se o projeto não tem ninguém procure outro
    if ($users->count() <= 0) {
        return _comment_factory_($faker);   
    }

    $user = $users->random();
    $tasks = $user->tasks()->get();

    // Se o usuário não está em nenhuma tarefa para comentar
    // procure outro
    if ($tasks->count() <= 0) {
        return _comment_factory_($faker);   
    }

    $task = $tasks->random();
    
    return [
        'contents' => $faker->sentence(),
        'user_id' => $user->id,
        'task_id' => $task->id,
    ];

}

$factory->define(App\Comment::class, '_comment_factory_');
