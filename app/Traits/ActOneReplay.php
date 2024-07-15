<?php

namespace App\Traits;

use App\Http\Livewire\Game\Player\GameActOne;

trait ActOneReplay
{
    public array $history = [];
    public array $replayState = [];
    public bool $showReplay = false;

    protected ?GameActOne $playerClass;
    public string $replayCharacter;
    public array $characterActions = [];
    public string|array $actionReplay;

    public function watchReplay(): void
    {
        $this->showReplay = true;
        $this->history = $this->game->refresh()->state['action_history'];

        $this->updateReplayState(
            $this->loadStartingActOneState(replay: true),
            'nextReplayAction',
        );
    }

    protected function updateReplayState($newState, $replayEvent): void
    {
        $parsedReplayState = $this->gameState;
        $previous_character = null;

        if (\key_exists('action_history', $newState) && isset($this->gameState['active_character'])) {
            $previous_character = $this->gameState['active_character'];
        }

        foreach ($newState as $key => $value) {
            if ($key !== 'play_event_card' && $key !== 'action_history') {
                $parsedReplayState[$key] = $value;
            }
        }

        if ($previous_character) {
            $actions = $this->parseActions($previous_character, $newState['action_history'], $parsedReplayState);
            foreach($actions as $key => $action) {
                // Modify the Game State based on parsed actions
                $parsedReplayState[$key] = $action;
            }
        }

        // Simulate the GameWrapper event "refresh" event
        $parsedReplayState['show_shark'] = true;
        $parsedReplayState['video'] = null;
        $parsedReplayState['audio'] = null;
        $this->emitSelf('refreshActOneState', $parsedReplayState, $replayEvent);
    }

    public function nextReplayAction(): void
    {
        $key = collect($this->history)->keys()->first();

        if (! \key_exists($key, $this->history)) {
            $this->showReplay = false;

            return;
        }

        $this->replayState = $this->history[$key];
        unset($this->history[$key]);

        $this->replayCharacter = array_key_first($this->replayState);

        if ($this->replayCharacter === 'Card') {
            $this->updateReplayState(
                $this->playEventCard($this->replayState[$this->replayCharacter], replay: true),
                'nextReplayAction',
            );
        } else {
            $this->refreshPlayerGameState();
            $this->characterActions = $this->replayState[$this->replayCharacter];

            $this->updateReplayState(
                $this->playerClass->setActiveCharacter($this->replayCharacter),
                'nextCharacterAction',
            );
        }
    }

    public function nextCharacterAction(): void
    {
        $this->refreshPlayerGameState();

        // Get the next character action available
        $key = collect($this->characterActions)->keys()->first();
        $this->actionReplay = $this->characterActions[$key];
        unset($this->characterActions[$key]);

        $space = $this->getSpace($this->actionReplay);
        $action = $this->getAction($this->actionReplay);

        $this->updateReplayState(
            $this->playerClass->setActionState($action, $space, replay: true),
            count($this->characterActions) === 0 ? 'confirmReplayTurn' : 'nextCharacterAction',
        );
    }

    public function confirmReplayTurn(): void
    {
        $this->refreshPlayerGameState();

        $this->updateReplayState([
            'active_character' => null,
            'active_player' => 'N/A',
            'show_shark' => true,
            'video' => null,
            'audio' => null,
            $this->replayCharacter.'_moves' => 0,
        ], 'nextReplayAction');
    }

    private function refreshPlayerGameState(): void
    {
        $this->playerClass = new GameActOne();
        $this->playerClass->mount($this->game, $this->gameState);
    }
}
