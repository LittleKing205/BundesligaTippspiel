<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipp extends Model
{
    use HasFactory;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function match() {
        return $this->belongsTo(Match::class);
    }
}
