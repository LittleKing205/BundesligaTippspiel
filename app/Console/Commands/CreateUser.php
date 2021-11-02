<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

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
        $username = $this->ask("Benutzername / Loginame:");
        $name = $this->ask("Anzeigename:");
        $email = $this->ask("E-Mail Adresse:");
        $password = $this->secret("Passwort");
        $is_admin = $this->confirm('Ist dieser User ein Admin?');

        $user = User::create([
            "name" => $name,
            "username" => $username,
            "email" => $email,
            "password" => Hash::make($password)
        ]);

        if ($is_admin) {
            $role = Role::where("name", __('role_names.admin'))->first();
            $user->assignRole(__('role_names.admin'));
        }

        $this->info("Der Benutzer wurde erfolgreich angelegt");

        return 0;
    }
}
