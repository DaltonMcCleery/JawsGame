<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class AvailableGames extends Component
{
    public $games = [];
    public $game_id = null;
    public $joining_game_id = null;

    public function loadGames() {
        $this->games = Game::whereColumn('max_sessions', '!=', 'current_sessions')
            ->where('status', 'not started')
            ->latest()
            ->get();
    }

    /**
     * Create a New Game to play
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createGame() {
        // Randomly generate Session ID
        $session_id = Str::random();

        // Create the New Game tied to the current authed User
        Game::create([
            'session_id'    => $session_id,
            'game_id'       => $this->game_id,
            'host_id'       => Auth::user()->id
        ]);

        return redirect('/play/lobby/'.$session_id);
    }

    public function joinGame($gameId) {
        $game = Game::find($gameId);

        if ($game->game_id !== null && $this->joining_game_id === $game->game_id) {
            // Join game
            return redirect('/play/lobby/'.$game->session_id);
        }

        $this->addError('joining_game_id', 'Invalid Game Password');
    }

    public function render()
    {
        return view('livewire.available-games');
    }
}
