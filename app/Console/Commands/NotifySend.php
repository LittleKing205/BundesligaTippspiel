<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\CustomMessage;
use Illuminate\Console\Command;

class NotifySend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:send {--t|title=} {--m|message=*} {--u|user=*}';

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
        $title = null;
        if (trim($this->option('title')) != "")
            $title = $this->option('title');

        if (count($this->option('message')) > 0) {
            $users = array();
            if (count($this->option('user')) > 0) {
                foreach($this->option('user') as $userInput) {
                    if (is_numeric($userInput)) {
                        $dbUser = User::find($userInput);
                    } else {
                        $dbUser = User::where('name', $userInput)->first();
                    }
                    if (!is_null($dbUser))
                        $users[] = $dbUser;
                }
            } else {
                $users = User::all();
            }

            foreach($users as $user) {
                $user->notify(new CustomMessage($this->option('message'), $title));
            }
        } else {
            $this->error("No Message was defined");
        }
    }
}
