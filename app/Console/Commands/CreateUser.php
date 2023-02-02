<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user 
    {--admin : Defines if user has an administrator role}
    {name} 
    {email} 
    {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $isAdmin = $this->option('admin');
        $data = [
            'email' => $this->argument('email'),
            'name' => $this->argument('name'),
            'password' => Hash::make($this->argument('password')),
        ];
        if ($isAdmin) {
            $hasUser = Admin::where('email', $data['email'])->get();

            if (!$hasUser) {
                Admin::firstOrCreate(
                    ['email' => $data['email']],
                    $data
                );

                $this->info('Admin user created successfully');
                return Command::SUCCESS;
            } else {
                $this->info("Admin user is already created.");
            }
        } else {

            $hasUser = User::where('email', $data['email'])->first();

            if (!$hasUser) {
                User::firstOrCreate(
                    ['email' => $data['email']],
                    $data
                );

                $this->info('User created successfully');
                return Command::SUCCESS;
            } else {
                $this->info("User is already created.");
            }
            
        }

        $this->error("Command could not create the user");

        return Command::FAILURE;
    }
}
