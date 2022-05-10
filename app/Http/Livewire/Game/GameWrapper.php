<?php

namespace App\Http\Livewire\Game;

use App\Events\Game\newGameCards;
use App\Events\Game\newGameState;
use App\Models\Card;
use App\Models\Game;
use App\Traits\ActOneActions;
use Livewire\Component;

class GameWrapper extends Component
{
    use ActOneActions;

    public Game $game;
    public int $act = 1;

    public array $cards = [];
    public array $usedCards = [];

    public array $gameState = [];

    protected $listeners = [
        'setGameState',
        'resetGameState',
        'resetGameCards'
    ];

    /**
     * @param Game $game
     */
    public function mount(Game $game) {
        $this->game = $game;

        $this->cards = [
            'Event' => Card::where('type', 'Event')->inRandomOrder()->get(),
            'Shark Ability' => Card::where('type', 'Shark Ability')->inRandomOrder()->get(),
            'Resurface' => Card::where('type', 'Resurface')->inRandomOrder()->get(),
            'Crew' => Card::where('type', 'Crew')->inRandomOrder()->get(),
        ];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setGameState(array $newState) {
        $play_card = null;
        $card = null;
        $previous_character = null;

        if (\key_exists('action_history', $newState) && isset($this->gameState['active_character'])) {
            $previous_character = $this->gameState['active_character'];
        }

        foreach ($newState as $key => $value) {
            if ($key === 'play_event_card') {
                $play_card = $value;
                $card = $this->getCard($value);

                $this->gameState['action_history'][] = ['Card' => $card];
            } else {
                if ($key === 'action_history') {
                    // Add on
                    $this->gameState['action_history'][] = $value;
                } else {
                    $this->gameState[$key] = $value;
                }
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
            // Check for end state
            if ($this->gameState['shark_barrels'] >= 2 || $this->gameState['swimmers_eaten'] >= 9) {
                $this->gameState['act_1_over'] = true;
                $this->gameState['shark_moves'] = 0;
                $this->gameState['brody_moves'] = 0;
                $this->gameState['hooper_moves'] = 0;
                $this->gameState['quint_moves'] = 0;
            }

            $this->emit('refreshActOneState', $this->gameState);
        }
        elseif ($this->act === 2) {
            $this->emit('refreshActTwoState', $this->gameState);
        }

        broadcast(new newGameState($this->game->session_id, $this->gameState));

        $this->game->update(['state' => $this->gameState]);

        if ($play_card && $card) {
            broadcast(new newGameCards($this->game->session_id, $card, $this->cards, $this->usedCards));
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

    public function getCard($type) {
        // Get a new collection instance of possible Cards by the given Type and select a random one to be broadcast
        $possible_cards = collect($this->cards[$type]);
        $card = ($possible_cards->random(1))[0];

        $remaining_cards = $possible_cards->filter(function ($item) use ($card) {
            return $item != $card;
        })->toArray();

        $this->cards[$type] = $remaining_cards;
        $this->usedCards[$type][] = $card;

        return $card;
    }
}
