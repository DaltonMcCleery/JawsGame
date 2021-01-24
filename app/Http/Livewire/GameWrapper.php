<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;

class GameWrapper extends Component
{
    public $game;
    public $act = 1;

    public $gameState = [];

    protected $listeners = [
        'setGameState'
    ];

    public function mount(Game $game) {
        $this->game = $game;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setGameState(array $newState) {
        foreach ($newState as $key => $value) {
            $this->gameState[$key] = $value;
        }

        if ($this->act === 1) {
            $this->emit('refreshActOneState', $this->gameState);
        }
        elseif ($this->act === 2) {
            $this->emit('refreshActTwoState', $this->gameState);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //


    public function render()
    {
        return view('livewire.game-wrapper');
    }
}
