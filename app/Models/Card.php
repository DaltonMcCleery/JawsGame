<?php

namespace App\Models;

class Card
{
    protected $table = 'cards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'image', 'description', 'token', 'action'
    ];
}
