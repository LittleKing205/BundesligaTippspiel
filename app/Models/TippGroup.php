<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class TippGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id'
    ];

    protected $casts = [
        'invites_enabled' => 'boolean',
        'pot_enabled' => 'boolean',
    ];

    public function owner() {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function getUsersAttribute() {
        $usersList = UserGroup::where('tipp_group_id', $this->id)->get();
        $users = array();
        foreach($usersList as $user) {
            $users[] = User::find($user->user_id);
        }
        return collect($users);
    }

    public function bills() {
        return $this->hasMany(Bill::class);
    }

    public function changeInviteCode() {
        $this->invite_code = substr(str_replace('/', '', str_replace('.', '', Hash::make(Carbon::now()->timestamp))), -7);
        $this->save();
    }
}
