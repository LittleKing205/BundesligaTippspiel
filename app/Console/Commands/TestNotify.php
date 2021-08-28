<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Console\Command;

class TestNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:test {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tested den Benarichtigungsdienst';

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
        $userParam = $this->argument("user");
        $user = null;
        if (is_numeric($userParam))
            $user = User::find($userParam);
        else
            $user = User::where('username', $userParam)->get()[0];

        if (is_null($user)) {
            $this->error("Der angegebene User konnte nicht gefunden werden");
            return;
        }

        $user->notify(new TestNotification());
    }
}
