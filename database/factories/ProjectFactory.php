<?php

use Faker\Generator as Faker;

$factory->define(\App\Project::class, function (Faker $faker) {

    // Sortear um cliente aleatório
    $clis = \App\Client::All();

    return [
        'name' => $faker->catchPhrase,
        'description' => $faker->bs,
        'client_id' => $clis->random()->id,
    ];
});
