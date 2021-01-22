<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shark extends Model
{
    protected $table = 'shark';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'health', 'swimmers_ate', 'barrels', 'user_id'
    ];

    public function User() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function Game() {
        return $this->belongsTo('App\Models\Game', 'shark_id', 'd');
    }
}
