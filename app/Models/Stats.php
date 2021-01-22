<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Stats extends Model
{
    protected $table = 'stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'games_won',
        'won_as_shark', 'won_as_brody', 'won_as_hooper', 'won_as_quint',
        'times_picked_shark', 'times_picked_brody', 'times_picked_hooper', 'times_picked_quint'
    ];

    public function User() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
