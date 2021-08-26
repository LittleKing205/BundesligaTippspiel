<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function homeMatches() {
        return $this->HasMany('App\Models\Match', 'team1_id');
    }

    public function awayMatches() {
        return $this->HasMany('App\Models\Match', 'team2_id');
    }

    public function getMatchesAttribute() {
        return collect($this->homeMatches)->merge($this->awayMatches)->sortBy('match_start');
    }
}
