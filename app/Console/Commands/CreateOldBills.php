<?php

namespace App\Console\Commands;

use App\Http\Clients\OpenLiga;
use App\Models\Bill;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateOldBills extends Command
{
    private OpenLiga $openLiga;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:oldbills';

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
    public function __construct(OpenLiga $openLiga)
    {
        parent::__construct();
        $this->openLiga = $openLiga;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        $days = array(
            1 => $this->openLiga->getCurrentDay(1),
            2 => $this->openLiga->getCurrentDay(2)
        );

        foreach($users as $user) {
            foreach($days as $league => $day) {
                if ($days[$league] == 1)
                    continue;

                for ($i = 1; $i < $day; $i++) {
                    $groups = UserGroup::where('user_id', $user->id)->get();
                    foreach($groups as $group) {
                        $checkBill = Bill::where("user_id", $user->id)->where("league", $league)->where("day", $i)->where('tipp_group_id', $group->tipp_group_id)->first();
                        if (is_null($checkBill)) {
                            $this->call("make:bill", [
                                "user" => $user->id,
                                "league" => $league,
                                "day" => $i
                            ]);
                            break;
                        }
                    }
                }
            }
        }
    }
}
