<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TippGroup extends Model
{
    use HasFactory;

    public function getUsersAttribute() {
        $usersList = UserGroup::where('tipp_group_id', $this->id)->get();
        $users = array();
        foreach($usersList as $user) {
            $uers[] = User::find($user->user_id);
        }
        return $users;
    }
}
