<?php

namespace App\Http\Controllers;

use App\Events\Lobby\JoinLobby;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class LobbyController extends Controller
{
    /**
     * Join a Game's Lobby
     *
     * @param $session_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function lobby($session_id) {
        // Get Game based on Session ID
        $game = Game::where('session_id', $session_id);

        if ($game->exists()) {
            // Get Game settings
            $game = $game->first();

            // Check if the Game has started or not
            if ($game->status === 'has started') {
                // Can't join game that is in progress
                return redirect('/')->with('error', 'Cannot join a Game that is in progress!');
            }

            // Setup/Join Lobby
            broadcast(new JoinLobby(Auth::user(), $session_id));

            return view('lobby', ['game' => $game]);

        } else {
            // No Game found
            return redirect('/')->with('error', 'That game is full or invalid!');
        }
    }

    /**
     * Play a Game
     *
     * @param $session_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function play($session_id) {
        $game = Game::query()
            ->where('session_id', $session_id)
            ->first();

        if ($game && $game->status !== 'has ended') {
            return view('game', [
                'game' => $game,
            ]);
        } else {
            // Invalid Game
            return redirect('/')->with('error', 'That game is full or invalid!');
        }
    }

}
