<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id', 'game_id', 'host_id', 'max_sessions', 'current_sessions', 'status',
        'act', 'winner', 'shark_abilities', 'crew_gear',
        'shark_id', 'boat_id',
        'brody', 'hooper', 'quint',
        'brody_health', 'hooper_health', 'quint_health'
    ];

    public function Host() {
        return $this->hasOne('App\Models\User', 'id', 'host_id');
    }

    public function Winner() {
        return $this->hasOne('App\Models\User', 'id', 'winner');
    }

    public function Boat() {
        return $this->hasOne('App\Models\Boat', 'id', 'boat_id');
    }

    public function Shark() {
        return $this->hasOne('App\Models\Shark', 'id', 'shark_id');
    }

    public function Brody() {
        return $this->hasOne('App\Models\User', 'id', 'brody');
    }

    public function Hooper() {
        return $this->hasOne('App\Models\User', 'id', 'hooper');
    }

    public function Quint() {
        return $this->hasOne('App\Models\User', 'id', 'quint');
    }
}
