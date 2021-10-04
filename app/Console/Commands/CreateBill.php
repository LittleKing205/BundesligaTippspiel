<?php

namespace App\Console\Commands;

use App\Models\Bill;
use Illuminate\Console\Command;
use App\Models\Game;
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
        $wrong = 0;
        foreach($matches as $match) {
            if ($match->tipp != $match->result)
                $wrong += 1;
        }
        $toPay = ($wrong * 0.5) + (9 - count($matches));
        $bill = Bill::where("user_id", $this->argument("user"))->where("day", $this->argument("day"))->where("league", $this->argument("league"))->first();
        if (is_null($bill)) {
            Bill::create([
                "user_id" => $this->argument("user"),
                "league" => $this->argument("league"),
                "day" => $this->argument("day"),
                "to_pay" => $toPay
            ]);
        } else {
            $bill->to_pay = $toPay;
            $bill->save();
        }
    }
}
