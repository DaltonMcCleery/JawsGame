<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Stats extends Model
{
    protected $table = 'stats';

    public function user() {
        return $this->hasOne(User::class);
    }
}
