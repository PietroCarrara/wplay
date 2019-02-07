<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Hash;
use App\User;

class BootstrapRoot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:root {email} {pass} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um usuário com privilégios de admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $pass = $this->argument('pass');
        $name = $this->argument('name');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('O primeiro argumento deve ser um email');
            return;
        }

        if (strlen($pass) < 6) {
            $this->error('O segundo argumento deve ser uma senha de no mínimo 6 caracteres');
            return;
        }

        if (User::where('email', $email)->count()) {
            $this->error('Email já em uso');
            return;
        }

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($pass),
            'name' => $name,
        ]);
        $user->role = 'admin';
        $user->save();
    }
}
