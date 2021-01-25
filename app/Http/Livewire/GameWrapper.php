<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;
use App\Traits\ActOneActions;
use App\Events\Game\newGameState;
use App\Events\Game\newGameCards;
use Illuminate\Support\Facades\Auth;

class GameWrapper extends Component
{
    use ActOneActions;

    public $game;
    public $act = 1;

    public $cards = [];
    public $usedCards = [];

    public $gameState = [];

    protected $listeners = [
        'setGameState',
        'resetGameState',
        'resetGameCards'
    ];

    /**
     * @param Game $game
     * @param $event_cards
     * @param $shark_ability_cards
     * @param $resurface_cards
     * @param $crew_cards
     */
    public function mount(Game $game, $event_cards, $shark_ability_cards, $resurface_cards, $crew_cards) {
        $this->game = $game;

        $this->cards = [
            'Event' => $event_cards,
            'Shark Ability' => $shark_ability_cards,
            'Resurface' => $resurface_cards,
            'Crew' => $crew_cards
        ];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setGameState(array $newState) {
        $play_card = null;
        $previous_character = null;

        if (key_exists('action_history', $newState)) {
            $previous_character = $this->gameState['active_character'];
        }

        foreach ($newState as $key => $value) {
            if ($key === 'play_card') {
                $play_card = $value;
            } else {
                $this->gameState[$key] = $value;
            }
        }

        if ($previous_character) {
            $actions = $this->parseActions($previous_character, $newState['action_history'], $this->gameState);
            foreach($actions as $key => $action) {
                // Modify the Game State based on parsed actions
                $this->gameState[$key] = $action;
            }
        }

        if ($this->act === 1) {
            $this->emit('refreshActOneState', $this->gameState);
        }
        elseif ($this->act === 2) {
            $this->emit('refreshActTwoState', $this->gameState);
        }

        broadcast(new newGameState($this->game->session_id, $this->gameState));

        if ($play_card) {
            $this->useCard($play_card);
        }
    }

    public function resetGameState(array $newState) {
        $this->gameState = $newState;

        if ($this->act === 1) {
            $this->emit('refreshActOneState', $this->gameState);
        }
        elseif ($this->act === 2) {
            $this->emit('refreshActTwoState', $this->gameState);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function useCard($type) {
        // Get a new collection instance of possible Cards by the given Type and select a random one to be broadcast
        $possible_cards = collect($this->cards[$type]);
        $card = ($possible_cards->random(1))[0];

        $remaining_cards = $possible_cards->filter(function ($item) use ($card) {
            return $item != $card;
        })->toArray();

        $this->cards[$type] = $remaining_cards;
        $this->usedCards[$type][] = $card;

        broadcast(new newGameCards($this->game->session_id, $card, $this->cards, $this->usedCards));
    }

    public function resetGameCards($data) {
        $this->cards = $data['cards'];
        $this->usedCards = $data['usedCards'];

        if ($this->act === 1) {
            $this->emit('playEventCard', $data['card']);
        }
        elseif ($this->act === 2) {
            $this->emit('playCard', $data['card']);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function switchNextAction($action) {
        if ($this->gameState['active_player'] === Auth::user()->username) {
            $this->gameState['current_selected_action'] = $action;

            if ($this->act === 1) {
                $this->emit('refreshActOneState', $this->gameState);
            }
            elseif ($this->act === 2) {
                $this->emit('refreshActTwoState', $this->gameState);
            }
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function render()
    {
        return view('livewire.game-wrapper');
    }
}
