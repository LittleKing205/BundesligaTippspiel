<?php

namespace App\Console\Commands;

use App\Http\Clients\OpenLiga;
use App\Models\Game;
use App\Models\Tipp;
use App\Models\User;
use App\Notifications\MatchCloseNotification;
use Illuminate\Console\Command;

class NotifyClosingGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:closing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks, if Matches are gonna be locked';

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
    public function handle(OpenLiga $openLiga)
    {
        $matches = Game::where('notified', 0)->orderBy('match_start', 'asc')->limit(20)->get();
        foreach($matches as $match) {
            if ($match->match_start < now()->addHours(5)) {
                $tmpUsers = User::all();
                foreach ($tmpUsers as $user) {
                    $tipp = Tipp::where('user_id', $user->id)->where('match_id', $match->id)->get();
                    if (count($tipp) == 0) {
                        $this->info('Notify '.$user->name.' for game '.$match->id.' ('.$match->team1->name.' - '.$match->team2->name.')');
                        $user->notify(new MatchCloseNotification($match));
                    }
                }
                $match->notified = true;
                $match->save();
            }
        }
    }
}
