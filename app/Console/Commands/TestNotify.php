<?php

namespace App\Console\Commands;

use App\Channels\JoinChannel;
use App\Channels\JoinSmsChannel;
use App\Channels\WebPushChannel;
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

        $channels = "";
        if (config('join_sms.enable') && !is_null($user->phone))
            $channels .= "SMS, ";
        if (!is_null($user->join_key))
            $channels .= "Join, ";
        if (config('firebase.enable') && !is_null($user->device_key))
            $channels .= "WebPush, ";
        $this->info("Es wurde ".$user->name." über ".$channels."Benachrichtigt");
    }
}
