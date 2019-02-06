<?php

use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {

    return [
        'name' => $faker->catchPhrase,
        'description' => $faker->sentence,
        'project_id' => \App\Project::All()->random()->id,
    ];
});
