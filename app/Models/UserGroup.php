<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tipp_group_id'
    ];

    public function tippGroup() {
        return $this->belongsTo(TippGroup::class, 'tipp_group_id');
    }
}
