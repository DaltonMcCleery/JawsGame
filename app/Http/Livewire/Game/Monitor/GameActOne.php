<?php

namespace App\Http\Livewire\Game\Monitor;

use App\Http\Livewire\Game\GameWrapper;
use App\Models\Game;
use App\Traits\ActOneActions;
use Livewire\Component;
use App\Traits\ActOneRules;
use App\Traits\ActOneCards;

class GameActOne extends Component
{
    use ActOneRules, ActOneCards, ActOneActions;

    public Game $game;
    public array $gameState;
    public array $localGameState = [];

    protected $listeners = ['refreshActOneState', 'playEventCard'];

    public function mount(Game $game, array $gameState) {
        $this->game = $game;
        $this->gameState = $gameState;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function loadStartingActOneState() {
        $this->emitTo(GameWrapper::class, 'setGameState', [
            // Crew Starting Positions & Equipped Barrels
            'quint_barrels' => 2,
            'quint_moves' => 4,
            'quint_position' => 'Space_8',
            'quint_last_position' => 'Space_8',
            'hooper_barrels' => 0,
            'hooper_moves' => 4,
            'hooper_position' => 'Space_5',
            'hooper_last_position' => 'Space_5',
            'brody_barrels' => 0,
            'brody_moves' => 4,
            'brody_position' => 'Space_7',
            'brody_last_position' => 'Space_7',
            // Barrels
            'Shop_barrels' => 6,
            'Space_5_barrels' => 0,
            'Space_8_barrels' => 0,
            // Beach Swimmers
            'North_Beach_Swimmers' => 0,
            'East_Beach_Swimmers' => 0,
            'South_Beach_Swimmers' => 0,
            'West_Beach_Swimmers' => 0,
            'closed_beach' => 'none',
            // Shark starting elements
            'shark_barrels' => 0,
            'shark_moves' => 3,
            'shark_position' => null,
            'shark_last_position' => null,
            'swimmers_eaten' => 0,
            'ignore_motion_sensors' => false,
            'locked_closed_beach' => false,
            // Act I
            'active_player' => 'monitor',
            'active_character' => 'shark',
            'current_description' => 'Waiting on Shark to pick a starting place',
            'current_phase' => null,
            'current_selected_action' => 'Starting Position',
            // Abilities
            'shark_hidden' => false,
            'binoculars' => null,
            'fish_finder' => null,
            'show_shark' => false,
            'shark_nearby' => [],
            'used_feeding_frenzy' => false,
            'used_out_of_sight' => false,
            'used_speed_burst' => false,
            'used_evasive_moves' => false
        ]);
    }

    public function refreshActOneState($newState) {
        $this->gameState = $newState;

        if ($newState['active_player'] !== 'monitor' || $this->localGameState === [] || $this->gameState['current_phase'] === "Event") {
            // Refresh local state
            $this->localGameState = $newState;
        }

        if (isset($this->gameState['act_1_over']) && $this->gameState['act_1_over'] === true) {
            // Auto-end the current Turn and display any Reply settings
            //
        }
        elseif ($this->gameState['shark_moves'] === 0
            && $this->gameState['brody_moves'] === 0
            && $this->gameState['hooper_moves'] === 0
            && $this->gameState['quint_moves'] === 0
            && $this->gameState['current_phase'] !== 'Event') {
            // No more moves left, restart phases
            $this->emitTo(GameWrapper::class, 'setGameState', [
                'active_character' => 'shark',
                'current_description' => 'Playing Event Card...',
                'current_phase' => 'Event',
                'active_player' => $this->game->Shark->User->username,
                'play_event_card' => 'Event'
            ]);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function playEventCard($card) {
        $data = $this->parseEventCard($card, $this->gameState);

        if (!$data) {
            $this->addError('action-error', 'Unable to parse Event Card');
        } else {
            $extra_data = [];
            if (isset($this->gameState['closed_beach_open_in'])) {
                $extra_data['closed_beach_open_in'] = $this->gameState['closed_beach_open_in'] - 1;

                if ($this->gameState['closed_beach_open_in'] === 0) {
                    // Open Beach
                    $extra_data = [
                        'closed_beach' => null,
                        'closed_beach_open_in' => null
                    ];
                }
            }
            elseif (isset($data['closed_beach'])) {
                $extra_data = [
                    'closed_beach' => $data['closed_beach'],
                    'closed_beach_open_in' => $data['closed_beach_open_in']
                ];
            }

            // Perform necessary Game updates
            $newGameState = array_merge($extra_data, [
                // Event Details
                'current_event_title' => $data['current_event_title'],
                'current_event_description' => $data['current_event_description'],
                'current_event_swimmers' => $data['current_event_swimmers'],
                // Specific Actions
                'quint_moves' => $data['quint_moves'] ?? 4,
                'quint_position' => $data['quint_position'] ?? $this->gameState['quint_position'],
                'hooper_moves' => $data['hooper_moves'] ?? 4,
                'hooper_position' => $data['hooper_position'] ?? $this->gameState['hooper_position'],
                'brody_moves' => $data['brody_moves'] ?? 4,
                'brody_position' => $data['brody_position'] ?? $this->gameState['brody_position'],
                'shark_moves' => $data['shark_moves'] ?? 3,
                // Extra Actions
                'captain_down' => $data['captain_down'] ?? 0,
                'closed_beach' => $data['closed_beach'] ?? $this->gameState['closed_beach'],
                'michael_position' => $data['michael_position'] ?? (isset($this->gameState['michael_position']) ? $this->gameState['michael_position'] : null),
                'extra_crew_move' => $data['extra_crew_move'] ?? 0,
                'free_docks' => $data['free_docks'] ?? 'false',
                'brody_relocation' => $data['brody_relocation'] ?? 0,
                'crew_relocation' => $data['crew_relocation'] ?? 0,
                'locked_closed_beach' => false,
                // Abilities reset
                'shark_hidden' => false,
                'binoculars' => null,
                'fish_finder' => null,
                'show_shark' => false,
                'shark_nearby' => [],
                'ignore_motion_sensors' => false,
                // Beach Swimmers
                'North_Beach_Swimmers' => $this->gameState['North_Beach_Swimmers'] + $data['North_Beach_Swimmers'],
                'East_Beach_Swimmers' => $this->gameState['East_Beach_Swimmers'] + $data['East_Beach_Swimmers'],
                'South_Beach_Swimmers' => $this->gameState['South_Beach_Swimmers'] + $data['South_Beach_Swimmers'],
                'West_Beach_Swimmers' => $this->gameState['West_Beach_Swimmers'] + $data['West_Beach_Swimmers'],
                // Event Phase is auto-followed by Shark Phase
                'active_player' => $this->game->Shark->User->username,
                'active_character' => 'shark',
                'current_description' => 'Waiting on Shark to finalize their move',
                'current_phase' => 'Shark',
                'current_selected_action' => null,
            ]);

            $this->localGameState = array_merge($this->localGameState, $newGameState);
            $this->emitTo(GameWrapper::class, 'setGameState', $newGameState);
        }
    }

    public function watchReplay() {
        $this->showReplay = true;
        $history = $this->gameState['action_history'];
        $this->loadStartingActOneState();

        // Loop through history and play it out
        foreach ($history as $index => $character_history) {
            if ($index > 0) {
                sleep(2);
            }

            $key = array_key_first($character_history);

            if ($key === 'Card') {
                $this->playEventCard($character_history[$key]);
            } else {

                $this->setActiveCharacter($key);

                foreach ($character_history[$key] as $action) {
                    sleep(2);
                    $space = $this->getSpace($action);
                    $action = $this->getAction($action);
                    $this->setActionState($action, $space, true);
                }

                $this->confirmTurn();
            }
        }
    }
}
