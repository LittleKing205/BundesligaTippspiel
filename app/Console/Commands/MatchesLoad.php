<?php

namespace App\Console\Commands;

use App\Http\Clients\OpenLiga;
use App\Models\Match;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MatchesLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:loadall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Läd alle Spiele aus OpenLigaDB';

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
        $teams = array();
        $this->output->info('Load Match Data:');
        $olMatches[1] = collect($openLiga->getMatchData(1));
        $olMatches[2] = collect($openLiga->getMatchData(2));
        $bar = $this->output->createProgressBar(count($olMatches[1]) + count($olMatches[2]));
        foreach($olMatches as $league => $olMatch) {
            foreach ($olMatch as $match) {
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
                foreach (['Team1', 'Team2'] as $team) {
                    $teams[$match[$team]['TeamId']] = array(
                        'id' => $match[$team]['TeamId'],
                        'name' => $match[$team]['TeamName'],
                        'badge' => $match[$team]['TeamIconUrl']
                    );
                }

                \App\Models\Match::upsert([
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

                $bar->advance();
            }
        }
        $this->output->info('Loaded All Match Data');
        $this->output->newLine(1);
        $this->output->info('Save All Teams:');
        $teamBar = $this->output->createProgressBar(count($teams));

        foreach ($teams as $team) {
            Team::upsert($team, ['id']);
            $teamBar->advance();
        }
        $this->output->info('Saved All Teams');
        $this->output->newLine(1);

        $this->info('Cleanup missed Notifications');
        $matches = \App\Models\Match::where('notified', 0)->get();
        $notifiedBar = $this->output->createProgressBar(count($matches));

        foreach($matches as $match) {
            if ($match->has_finished) {
                $match->notified = true;
                $match->save();
            }
            $notifiedBar->advance();
        }

        $this->output->info('Data loading Done');
    }
}
