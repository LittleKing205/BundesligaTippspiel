<?php

namespace App\Models;

use App\Channels\JoinChannel;
use App\Channels\JoinSmsChannel;
use App\Channels\WebPushChannel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'device_key',
        'join_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_treasurer' => 'boolean',
        'button_colors' => 'array'
    ];

    public function tipps() {
        return $this->hasMany(Tipp::class);
    }

    public function bills($tipp_group = null) {
        if (is_null($tipp_group))
            return $this->hasMany(Bill::class);
        else
            return Bill::where("user_id", $this->id)->where("tipp_group_id", $tipp_group)->get();
    }

    public function getNotificationChannel() {
        $activated = array();
        if (config('join_sms.enable') && !is_null($this->phone))
            $activated[] = JoinSmsChannel::class;
        if (!is_null($this->join_key))
            $activated[] = JoinChannel::class;
        if (config('firebase.enable') && !is_null($this->device_key))
            $activated[] = WebPushChannel::class;

        return $activated;
    }

    public function getGroupsAttribute() {
        $groups = UserGroup::where('user_id', $this->id)->get();
        $tipp_groups = array();
        foreach($groups as $group) {
            $tipp_groups[] = TippGroup::find($group->tipp_group_id);
        }
        return collect($tipp_groups);
    }

    public function currentGroup() {
        return $this->belongsTo(TippGroup::class, "current_group_id");
    }
}
