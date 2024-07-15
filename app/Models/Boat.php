<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    public function game() {
        return $this->belongsTo(Game::class);
    }
}
