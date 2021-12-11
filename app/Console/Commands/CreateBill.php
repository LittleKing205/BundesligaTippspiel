<?php

namespace App\Console\Commands;

use App\Models\Bill;
use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;

class CreateBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bill {user} {league} {day}';

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
        $matches = DB::table("games")->where("games.day", $this->argument("day"))->where("games.league", $this->argument("league"))->join("tipps", "games.id", "=", "tipps.game_id")->where("tipps.user_id", $this->argument("user"))->get();
        $right = 0;
        $wrong = 0;
        $not_tipped = 0;
        foreach($matches as $match) {
            if ($match->tipp == $match->result)
                $right += 1;
            else
                $wrong += 1;
        }
        $not_tipped = 9 - count($matches);
        $groups = UserGroup::where('user_id', $this->argument("user"))->get();
        foreach($groups as $group) {
            $bill = Bill::where("user_id", $this->argument("user"))->where("day", $this->argument("day"))->where("league", $this->argument("league"))->where('tipp_group_id', $group->tipp_group_id)->first();
            if ($group->tippGroup->payment_enabled)
                $toPay = ($wrong * $group->tippGroup->wrong_tipp) + ($not_tipped * $group->tippGroup->not_tipped);
            else
                $toPay = 0;
            if (is_null($bill)) {
                $bill = Bill::create([
                    "user_id" => $this->argument("user"),
                    "league" => $this->argument("league"),
                    "day" => $this->argument("day"),
                    "right" => $right,
                    "wrong" => $wrong,
                    "not_tipped" => $not_tipped,
                    "to_pay" => $toPay,
                    "tipp_group_id" => $group->tipp_group_id,
                ]);
                if ($toPay == 0) {
                    $bill->has_payed = true;
                    $bill->save();
                }
            } else {
                $bill->to_pay = $toPay;
                $bill->right = $right;
                $bill->wrong = $wrong;
                $bill->not_tipped = $not_tipped;
                $bill->save();
            }
        }
    }
}
