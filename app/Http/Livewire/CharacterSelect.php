<?php

namespace App\Http\Livewire;

use App\Events\Lobby\StartGame;
use App\Models\Game;
use Livewire\Component;
use App\Events\Characters\SyncCharacterSelection;

class CharacterSelect extends Component
{
    public Game $game;
    public string $session_id;

    public function mount(Game $game) {
        $this->game = $game;
        $this->session_id = $game->session_id;
    }

    public function startGame() {

        if ($this->game->monitor && $this->game->player) {
            $this->game->update([
                'status' => 'started'
            ]);

            broadcast(new StartGame(auth()->user(), $this->session_id));
        } else {
            $this->addError('character-error', 'Not Enough Characters!');
        }
    }

    public function getListeners(): array
    {
        return [
            'userJoiningCharacterLobby',
            'userLeavingCharacterLobby',
            'syncSelectedCharacters',
            "echo-presence:lobby.{$this->session_id},joining" => 'userJoiningCharacterLobby',
            "echo-presence:lobby.{$this->session_id},leaving" => 'userJoiningCharacterLobby',
        ];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function userJoiningCharacterLobby() {
        broadcast(new SyncCharacterSelection($this->session_id, [
            'game'  => $this->game,
        ]))->toOthers();
    }

    public function userLeavingCharacterLobby($user) {
        // De-select any character (if any)
        if ($this->game->monitor === $user->id) {
            $this->game->update([
                'monitor' => null
            ]);
        }

        if ($this->game->player === $user->id) {
            $this->game->update([
                'player' => null
            ]);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function userSelectedCharacter($model) {
        if ($this->game->$model && $this->game->$model !== auth()->id()) {
            $this->addError('character-error', 'Character already selected!');
        }
        elseif ($this->game->$model === auth()->id()) {
            // de-select
            $this->game->update([
                $model => null
            ]);
        }
        else {
            $this->game->update([
                $model => auth()->id()
            ]);
        }

        $this->game->refresh();

        if (count($this->getErrorBag()->get('character-error')) === 0) {
            $this->userJoiningCharacterLobby();
        }
    }

    public function syncSelectedCharacters($data) {
        $this->game = new Game($data);
    }
}
