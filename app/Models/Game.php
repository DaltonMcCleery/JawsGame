<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $casts = [
        'state' => 'array',
    ];

    public function host() {
        return $this->hasOne(User::class, 'id', 'host_id');
    }

    public function winner() {
        return $this->hasOne(User::class, 'id', 'winner');
    }

    public function boat() {
        return $this->hasOne(Boat::class, 'id', 'boat_id');
    }

    public function monitor() {
        return $this->hasOne(User::class, 'id', 'monitor');
    }

    public function player() {
        return $this->hasOne(User::class, 'id', 'player');
    }
}
