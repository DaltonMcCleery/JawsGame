<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;
use App\Traits\ActOneRules;
use App\Traits\ActOneCards;
use Illuminate\Support\Facades\Auth;

class GameActOne extends Component
{
    use ActOneRules, ActOneCards;

    public $game;
    public $gameState;

    /**
     * @var array Current Active Character's action history
     */
    public $currentActionState = [];

    protected $listeners = ['refreshActOneState', 'playEventCard'];

    public function mount(Game $game, array $gameState) {
        $this->game = $game;
        $this->gameState = $gameState;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function loadStartingActOneState() {
        $this->emitTo('game-wrapper', 'setGameState', [
            // Crew Starting Positions & Equipped Barrels
            'quint_barrels' => 2,
            'quint_moves' => 4,
            'quint_position' => 'Space_8',
            'hooper_barrels' => 0,
            'hooper_moves' => 4,
            'hooper_position' => 'Space_5',
            'brody_barrels' => 0,
            'brody_moves' => 4,
            'brody_position' => 'Space_7',
            // Barrels
            'Shop_barrels' => 6,
            'Space_5_barrels' => 0,
            'Space_8_barrels' => 0,
            // Beach Swimmers
            'North_Beach_Swimmers' => 0,
            'East_Beach_Swimmers' => 0,
            'South_Beach_Swimmers' => 0,
            'West_Beach_Swimmers' => 0,
            // Shark starting elements
            'shark_barrels' => 0,
            'shark_moves' => 3,
            'shark_position' => null,
            'swimmers_eaten' => 0,
            'ignore_motion_sensors' => false,
            // Act I
            'active_player' => $this->game->Shark->User->username,
            'active_character' => 'shark',
            'current_description' => 'Waiting on Shark to pick a starting place',
            'current_phase' => null,
            'current_selected_action' => 'Starting Position',
            // Abilities
            'shark_hidden' => false,
            'binoculars' => null,
            'fish_finder' => null,
            'show_shark' => false,
            'shark_nearby' => false
        ]);
    }

    public function refreshActOneState($newState) {
        $this->gameState = $newState;

        if ($this->gameState['shark_moves'] === 0
            && $this->gameState['brody_moves'] === 0
            && $this->gameState['hooper_moves'] === 0
            && $this->gameState['quint_moves'] === 0
            && $this->gameState['current_phase'] !== 'Event') {
            // No more moves left, restart phases
            $this->emitTo('game-wrapper', 'setGameState', [
                'active_character' => 'shark',
                'current_description' => 'Playing Event Card...',
                'current_phase' => 'Event',
                'active_player' => $this->game->Shark->User->username,
                'play_card' => 'Event'
            ]);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setActiveCharacter($character, $moveDescription = null) {
        // Find who's playing that Character
        $active_player = null;
        switch ($character) {
            case 'shark':
                $active_player = $this->game->Shark->User->username;
                break;

            case 'brody':
                $active_player = $this->game->Brody->username;
                break;

            case 'hooper':
                $active_player = $this->game->Hooper->username;
                break;

            case 'quint':
                $active_player = $this->game->Quint->username;
                break;
        }

        $this->emitTo('game-wrapper', 'setGameState', [
            'active_character' => $character,
            'current_description' => $moveDescription ?? (ucfirst($character).'\'s Turn In progress...'),
            'active_player' => $active_player
        ]);
    }

    public function setActionState($action, $space) {
        $this->currentActionState[] = $action.' ('.$space.')';

        if (str_contains($action, 'Move')) {
            $this->emitTo('game-wrapper', 'setGameState', [
                $this->gameState['active_character'].'_position' => $space
            ]);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setSharkStartingPosition($position) {
        $this->emitTo('game-wrapper', 'setGameState', [
            'shark_position' => $position,
            'current_description' => 'Playing Event Card...',
            'current_phase' => 'Event',
            'play_card' => 'Event'
        ]);
    }

    public function attemptAction($space) {
        if ($this->gameState['active_player'] === Auth::user()->username) {
            if ($this->gameState['current_selected_action'] === 'Starting Position') {
                // Move on to actual play
                $this->setSharkStartingPosition($space);
            }
            elseif ($this->isValidAction($this->gameState['active_character'], $this->gameState['current_selected_action'], $space, $this->currentActionState, $this->gameState)) {
                // Do it
                $this->setActionState($this->gameState['current_selected_action'], $space);
            }
            else {
                // fail
                $this->addError('action-error', 'Invalid Move');
            }
        } else {
            $this->addError('action-error', 'Not your turn');
        }
    }

    public function confirmTurn() {
        $next_phase = '...';
        $phase_description = 'Waiting on next Phase';

        if ($this->gameState['active_character'] === 'shark') {
            $next_phase = 'Crew';
            $phase_description = 'Waiting on Crew to decide who is next';
        }

        $this->emitTo('game-wrapper', 'setGameState', [
            'active_character' => null,
            'current_description' => $phase_description,
            'current_phase' => $next_phase,
            'active_player' => 'N/A',
            ($this->gameState['active_character'].'_moves') => 0,
            'action_history' => $this->gameState['action_history'][] = [$this->gameState['active_character'] => $this->currentActionState]
        ]);

        // Reset current actions list
        $this->currentActionState = [];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function playEventCard($card) {
        $data = $this->parseEventCard($card, $this->gameState);

        if (!$data) {
            $this->addError('action-error', 'Unable to parse Event Card');
        } else {
            // Perform necessary Game updates
            $this->emitTo('game-wrapper', 'setGameState', [
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
                'closed_beach' => $data['closed_beach'] ?? 'none',
                'extra_crew_move' => $data['extra_crew_move'] ?? 0,
                'free_docks' => $data['free_docks'] ?? 'false',
                'brody_relocation' => $data['brody_relocation'] ?? 0,
                'crew_relocation' => $data['crew_relocation'] ?? 0,
                'michael_position' => $data['michael_position'] ?? null,
                // Abilities reset
                'shark_hidden' => false,
                'binoculars' => null,
                'fish_finder' => null,
                'show_shark' => false,
                'shark_nearby' => false,
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
                'current_phase' => 'Shark'
            ]);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function render()
    {
        return view('livewire.game-act-one');
    }
}
