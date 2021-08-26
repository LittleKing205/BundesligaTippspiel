<?php

namespace App\Console\Commands;

use App\Http\Clients\OpenLiga;
use App\Models\Game;
use App\Models\User;
use App\Notifications\DayEndNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class MatchesLoadCurrentDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:loadcurrent';

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
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(OpenLiga $openLiga) {
        $loadCount = 0;
        foreach ([1,2] as $league) {
            $lastChange = Carbon::parse($openLiga->getLastChanges($league))->timestamp;
            $leagueEnd = true;
            if (Cache::get("lastChange_bl".$league) != $lastChange) {
                $matches = $openLiga->getMatchData($league, $openLiga->getRawDay($league));
                $loadCount += count($matches);
                foreach ($matches as $match) {
                    if (isset($match['MatchResults'][0])) {
                        $team1 = $match['MatchResults'][0]['PointsTeam1'];
                        $team2 = $match['MatchResults'][0]['PointsTeam2'];
                        $result = ($team1 > $team2) ? 1 : 2;
                        if ($team1 == $team2) $result = 0;
                    } else {
                        $team1 = null;
                        $team2 = null;
                        $result = null;
                    }
                    Game::upsert([
                        'id' => $match['MatchID'],
                        'team1_id' => $match['Team1']['TeamId'],
                        'team2_id' => $match['Team2']['TeamId'],
                        'league' => $league,
                        'day' => $match['Group']['GroupOrderID'],
                        'match_start' => Carbon::parse($match['MatchDateTime']),
                        'has_finished' => $match['MatchIsFinished'],
                        'team1_points' => $team1,
                        'team2_points' => $team2,
                        'result' => $result
                    ], ['id']);
                    if ($match['MatchIsFinished'] == false)
                        $leagueEnd = false;
                }
                Cache::forever("lastChange_bl".$league, $lastChange);
            }
            if($leagueEnd && Cache::get('lastNotifiedEnd_bl'.$league, -1) != $openLiga->getCurrentDay($league)) {
                $users = User::all();
                foreach ($users as $user) {
                    $user->notify(new DayEndNotification($league));
                }
                Cache::forever('lastNotifiedEnd_bl'.$league, $openLiga->getCurrentDay($league));
                $this->info("Notified Users, that day is end on league bl".$league);
            }
        }
        $this->info("Loaded ".$loadCount." matches.");
    }
}
