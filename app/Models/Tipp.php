<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipp extends Model
{
    public function users() {
        return $this->hasMany(User::class);
    }

    public function game() {
        return $this->belongsTo(Game::class);
    }
}
