<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class GameActTwo extends Component
{
    public $game;
    public $gameState;

    protected $listeners = ['refreshAcTwoState'];

    public function mount(Game $game, $gameState) {
        $this->game = $game;
        $this->gameState = $gameState;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function loadStartingActTwoState() {

    }

    public function refreshActTwoState($newState) {
        $this->gameState = $newState;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function render()
    {
        return view('livewire.game-act-two');
    }
}
