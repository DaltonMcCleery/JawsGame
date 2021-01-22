<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    protected $table = 'boat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tile_1_health', 'tile_2_health', 'tile_3_health', 'tile_4_health',
        'tile_5_health', 'tile_6_health', 'tile_7_health', 'tile_8_health',
        'brody_target', 'hooper_target', 'quint_target',
        'brody_position', 'hooper_position', 'quint_position'
    ];

    public function Game() {
        return $this->belongsTo('App\Models\Game', 'boat_id', 'id');
    }
}
