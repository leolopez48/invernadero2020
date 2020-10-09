<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Hash;

class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:createAdmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the default user which is the admin. 
    This command is needed to run only the first time.';

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
     * @return int
     */
    public function handle()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'typeAccess' => 1,
            'stationsSuscribed' => collect(["1", "2"])->toArray(),
        ]);
        User::create([
            'name' => 'Usuario 1',
            'email' => 'usuario@gmail.com',
            'password' => Hash::make('12345678'),
            'typeAccess' => 2,
            'stationsSuscribed' => collect(["1"])->toArray(),
        ]);
        return 0;
    }
}
