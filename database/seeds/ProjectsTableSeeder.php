<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Project::class, 10)->create()->each(function($project) {
            $users = \App\User::All();

            // Ordenar aleatóriamente
            $users = $users->shuffle();
            
            // Adicionar usuários no projeto
            for ($i = 0; $i < 5 && $i < $users->count(); $i++) {
                $project->users()->save($users[$i]);
            }
        });
    }
}
