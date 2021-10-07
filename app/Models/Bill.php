<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'league',
        'day',
        'right',
        'wrong',
        'not_tipped',
        'to_pay'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'has_payed' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
