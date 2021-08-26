<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'match_start'
    ];

    protected $casts = [
        'league' => 'integer',
        'day' => 'integer',
        'has_finished' => 'boolean',
        'results' => 'integer',
        'team1_points' => 'integer',
        'team2_points' => 'integer',
        'notified' => 'boolean'
    ];

    protected $guarded = ['notified'];

    public function tipps() {
        return $this->hasMany(Tipp::class);
    }

    public function team1() {
        return $this->belongsTo('App\Models\Team', 'team1_id');
    }

    public function team2() {
        return $this->belongsTo('App\Models\Team', 'team2_id');
    }
}
