<?php

namespace App\Broadcasting;

use App\Models\User;

class LobbyChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Add a User to a Lobby Broadcast Channel
     *
     * @param  User $user
     * @return User
     */
    public function join(User $user)
    {
        return $user;
    }
}
