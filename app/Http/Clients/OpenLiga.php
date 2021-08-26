<?php

namespace App\Http\Clients;

use App\Models\Game;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OpenLiga {
    private array $rawCurrentDay = array();
    private string $BASE_URL = "https://www.openligadb.de/api";
    private int $season;

    public function __construct($season) {
        $this->season = $season;
    }

    public function getCurrentDay($league) {
        if (Cache::has("currentDayForLeague".$league))
            return Cache::get("currentDayForLeague".$league);
        else {
            $tmpDay = $this->getRawDay($league);
            $lastMatch = Game::where("league", $league)->where("day", $tmpDay)->orderBy('match_start', 'desc')->first();
            if (!(now() < $lastMatch->match_start->addHours(2)))
                $tmpDay++;
            Cache::put("currentDayForLeague".$league, $tmpDay, now()->addMinutes(1));
            return $tmpDay;
        }
    }

    public function getRawDay($league) {
        if (!isset($this->rawCurrentDay[$league])) {
            $response = HTTP::acceptJson()->get($this->BASE_URL.'/getcurrentgroup/bl'.$league)->json();
            $this->rawCurrentDay[$league] = $response['GroupOrderID'];
        }
        return $this->rawCurrentDay[$league];
    }

    public function getMatchData($league, $day = null) {
        if (is_null($day))
            $day = '';
        else
            $day = "/".$day;
        return HTTP::acceptJson()->get($this->BASE_URL . '/getmatchdata/bl'. $league .'/'.$this->season.$day)->json();
    }

    public function getLastChanges($league) {
        return str_replace('"', "", HTTP::acceptJson()->get($this->BASE_URL.'/getlastchangedate/bl'.$league.'/'.$this->season.'/'.$this->getRawDay($league)));
    }
}
