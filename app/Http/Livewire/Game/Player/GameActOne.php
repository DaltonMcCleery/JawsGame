<?php

namespace App\Http\Livewire\Game\Player;

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

    /**
     * @var array Current Active Character's action history
     */
    public array $currentActionState = [];

    protected $listeners = ['refreshActOneState'];

    public function mount(Game $game, array $gameState) {
        $this->game = $game;
        $this->gameState = $gameState;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function refreshActOneState($newState) {
        $this->gameState = $newState;
        $this->localGameState = $newState;

        if (isset($this->gameState['act_1_over']) && $this->gameState['act_1_over'] === true) {
            // Auto-end the current Turn and display any Reply settings
            $this->confirmTurn();
        }

        if (isset($newState['refreshActionState']) && $newState['refreshActionState'] === true) {
            $lastActions = collect($newState['action_history'][0])->last();
            $character = array_keys($lastActions)[0];
            if ($character === $newState['active_character']) {
                $this->currentActionState = $lastActions[array_keys($lastActions)[0]] ?? [];
            }
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setActiveCharacter($character, $moveDescription = null) {
        $this->emitTo(GameWrapper::class, 'setGameState', [
            'active_character' => $character,
            ($character.'_last_position') => $this->gameState[$character.'_position'],
            'current_description' => $moveDescription ?? (ucfirst($character).'\'s Turn In progress...'),
            'active_player' => 'player',
            'current_selected_action' => null,
            'refreshActionState' => false,
            'show_shark' => $character === 'shark'
                ? false
                : ($this->gameState['show_shark'] ?? false),
        ]);
    }

    public function setActionState($action, $space, $replay = false) {
        $this->currentActionState[] = $action.' ('.$space.')';

        $actions = ['action_history' => [$this->gameState['active_character'] => [$action.' ('.$space.')']]];
        if (\str_contains($action, 'Move') || \str_contains($action, 'Speed Burst')) {
            $this->emitTo(GameWrapper::class, 'setGameState', [
                $this->gameState['active_character'].'_position' => $space,
                $this->gameState['active_character'].'_last_position' => $this->gameState[$this->gameState['active_character'].'_position']
            ]);
        }
        elseif (\str_contains($action, 'Use') || \str_contains($action, 'Launch a Barrel')) {
            // Take action immediately
            $this->emitTo(GameWrapper::class, 'setGameState', $actions);
        }
        else {
            // Commit directly to local game state
            $actions = $this->parseActions($this->gameState['active_character'], $actions['action_history'], $this->localGameState);
            foreach($actions as $key => $action) {
                // Modify the Game State based on parsed actions
                $this->localGameState[$key] = $action;
            }

            if ($replay) {
                $this->emitTo(GameWrapper::class, 'setGameState', $actions);
            }
        }
    }

    public function switchNextAction($action) {
        $this->emitTo(GameWrapper::class, 'setGameState', [
            'current_selected_action' => $action,
            'refreshActionState' => false,
        ]);
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setActivePlayer($character) {
        $this->emitTo(GameWrapper::class, 'setGameState', [
            'active_character' => $character,
            'active_player' => 'Player',
            'current_description' => 'Waiting on '.ucwords($character).' to finalize their move',
            'current_selected_action' => null,
            'audio' => null,
            'video' => null,
            'refreshActionState' => false,
        ]);
    }

    public function attemptAction($space) {
        if ($this->gameState['current_selected_action'] === 'Starting Position') {
            // Move on to actual play
            if ($space === 'Shop') {
                $this->addError('action-error', 'Cannot start here');
            } else {
                $this->emitTo(GameWrapper::class, 'setGameState', [
                    'shark_position' => $space,
                    'shark_last_position' => $space,
                    'current_description' => 'Playing Event Card...',
                    'current_phase' => 'Event',
                    'play_event_card' => 'Event',
                ]);
            }
        }
        else {
            $errors = $this->isValidAction(
                $this->gameState['active_character'],
                $this->gameState['current_selected_action'],
                $space,
                $this->currentActionState,
                $this->gameState,
                $this->localGameState
            );

            $error_count = count($errors);

            if ($error_count > 0) {
                // fail
                $message = '';
                foreach ($errors as $key => $error) {
                    $message.= $error;
                    if ($key+1 !== $error_count) {
                        $message.= ', ';
                    }
                }

                $this->addError('action-error', $message);
            } else {
                // Do it
                $this->setActionState($this->gameState['current_selected_action'], $space);
            }
        }
    }

    public function undoPreviousAction() {
        $lastAction = $this->currentActionState[count($this->currentActionState) - 1];
        if (
            \str_contains($lastAction, 'Use')
            || \str_contains($lastAction, 'Launch a Barrel')
            || str_contains($lastAction, 'Ability')
        ) {
            $this->addError('action-error', 'Cannot Undo Ability');
        }
        elseif (\str_contains($lastAction, 'Get Back on the Boat')) {
            $this->addError('action-error', 'Cannot Undo This Action');
        }
        else {
            // Undo previous Action state and re-apply action before last (if a Move)
            unset($this->currentActionState[count($this->currentActionState) - 1]);

            foreach ($this->currentActionState as $prevAction) {
                if (\str_contains($prevAction, 'Move')) {
                    $exploded = explode('(', $prevAction);
                    $space = rtrim($exploded[1], ')');

                    $this->emitTo(GameWrapper::class, 'setGameState', [
                        $this->gameState['active_character'].'_position' => $space
                    ]);

                    break;
                }
            }

            if (count($this->currentActionState) === 0) {
                // GO back to last known Space
                $this->emitTo(GameWrapper::class, 'setGameState', [
                    $this->gameState['active_character'].'_position' => $this->gameState[$this->gameState['active_character'].'_last_position']
                ]);
            }
        }
    }

    public function confirmTurn($replay = false) {
        $next_phase = '...';
        $phase_description = 'Waiting on next Phase';

        if ($this->gameState['active_character'] === 'shark') {
            $next_phase = 'Crew';
            $phase_description = 'Waiting on Crew to decide who is next';
        }

        // Filter out Ability actions (as they have already happened)
        $force = false;
        foreach ($this->currentActionState as $key => $action) {
            if (\str_contains($action, 'Use') || \str_contains($action, 'Launch a Barrel')) {
                // Remove
                $force = true;
                unset($this->currentActionState[$key]);
            }
        }

        if (isset($this->gameState['act_1_over']) && $this->gameState['act_1_over'] === true) {
            return;
        }
        elseif (count($this->currentActionState) > 0 || $force == true) {
            $video = null;

            if ($this->gameState['active_character'] === 'shark' && ! $replay) {
                $video = collect([
                    'attack_1',
                    'attack_2',
                    'attack_3',
                    'attack_4',
                    'attack_5',
                ])->random();
            }

            $this->emitTo(GameWrapper::class, 'setGameState', [
                'active_character'                                => null,
                'current_description'                             => $phase_description,
                'current_phase'                                   => $next_phase,
                'active_player'                                   => 'N/A',
                'video'                                           => $video,
                ($this->gameState['active_character'] . '_moves') => 0,
                'action_history'                                  => $this->gameState['action_history'][] = [$this->gameState['active_character'] => $this->currentActionState]
            ]);
        }

        // Reset current actions list
        $this->currentActionState = [];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function takeExtraMove() {
        if ($this->gameState['extra_crew_move'] === 1) {
            $this->localGameState[$this->gameState['active_character'].'_moves']++;
            $this->emitTo(GameWrapper::class, 'setGameState', [
                'extra_crew_move' => 0,
                ($this->gameState['active_character'].'_moves') => $this->gameState[$this->gameState['active_character'].'_moves'] + 1
            ]);
        }
    }

    public function getBackUp() {
        $this->currentActionState[] = 'Get Back on the Boat (Part 1)';
        $this->currentActionState[] = 'Get Back on the Boat (Part 2)';

        foreach ($this->gameState['in_water'] as $key => $character) {
            if ($character === $this->gameState['active_character']) {
                unset($this->gameState['in_water'][$key]);
                $this->emitTo('game-wrapper', 'setGameState', [
                    'in_water' => $this->gameState['in_water']
                ]);
            }
        }
    }

    public function watchReplay(): void
    {
        $this->emitTo(\App\Http\Livewire\Game\Monitor\GameActOne::class, 'watchReplay');
    }
}
