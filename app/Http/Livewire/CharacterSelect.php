<?php

namespace App\Http\Livewire;

use App\Events\Lobby\startGame;
use App\Models\Game;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Events\Characters\syncCharacterSelection;

class CharacterSelect extends Component
{
    public $game;
    public $session_id;

    public $shark = null;
    public $brody = null;
    public $hooper = null;
    public $quint = null;

    protected $listeners = [
        'userJoiningCharacterLobby',
        'userLeavingCharacterLobby',
        'syncSelectedCharacters'
    ];

    public function mount(Game $game) {
        $this->game = $game;
        $this->session_id = $game->session_id;
    }

    public function startGame() {
        ($this->game)->update([
            'status' => 'started'
        ]);

        // Ensure all 3 Crew Characters have a Player (even if the same)
        $brody = $this->game->Brody;
        $hooper = $this->game->Hooper;
        $quint = $this->game->Quint;

        if ($brody === null) {
            // Fill player with whoever is playing Hooper
            if ($hooper === null) {
                // Fill both with whoever is playing Quint
                ($this->game)->update([
                    'brody' => $quint->id,
                    'hooper' => $quint->id
                ]);
            } else {
                ($this->game)->update([
                    'brody' => $hooper->id
                ]);
            }
        }

        if ($hooper === null) {
            // Fill player with whoever is playing Brody
            if ($brody === null) {
                // Fill both with whoever is playing Quint
                ($this->game)->update([
                    'brody' => $quint->id,
                    'hooper' => $quint->id
                ]);
            } else {
                ($this->game)->update([
                    'hooper' => $brody->id
                ]);
            }
        }

        if ($quint === null) {
            // Fill player with whoever is playing Brody
            if ($brody === null) {
                // Fill both with whoever is playing Hooper
                ($this->game)->update([
                    'brody' => $hooper->id,
                    'quint' => $hooper->id
                ]);
            } else {
                ($this->game)->update([
                    'quint' => $brody->id
                ]);
            }
        }

        broadcast(new startGame(Auth::user(), $this->session_id));
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function userJoiningCharacterLobby($user) {
        broadcast(new syncCharacterSelection($this->session_id, [
            'shark' => $this->shark,
            'brody' => $this->brody,
            'hooper' => $this->hooper,
            'quint' => $this->quint,
        ]));
    }

    public function userLeavingCharacterLobby($user) {
        // De-select any character (if any)
        $this->deSelect($user['username']);
    }

    private function deSelect($username, $skip = null) {
        if ($skip !== 'shark' && $this->shark === $username) {
            // de-select
            $this->shark = null;
            ($this->game)->Shark->update([
                'user_id' => null
            ]);
        }
        if ($skip !== 'brody' && $this->brody === $username) {
            // de-select
            $this->brody = null;
            ($this->game)->update([
                'brody' => null
            ]);
        }
        if ($skip !== 'hooper' && $this->hooper === $username) {
            // de-select
            $this->hooper = null;
            ($this->game)->update([
                'hooper' => null
            ]);
        }
        if ($skip !== 'quint' && $this->quint === $username) {
            // de-select
            $this->quint = null;
            ($this->game)->update([
                'quint' => null
            ]);
        }

        $this->game->refresh();
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function userSelectedCharacter($model) {
        $user_id = Auth::user()->id;
        $username = Auth::user()->username;

        switch ($model) {
            case 'shark':
                if ($this->shark === $username) {
                    // de-select
                    $this->shark = null;
                    ($this->game)->Shark->update([
                        'user_id' => null
                    ]);
                } else {
                    if ($this->shark === null) {
                        $this->shark = $username;
                        ($this->game)->Shark->update([
                            'user_id' => $user_id
                        ]);
                    } else {
                        // already selected
                        $this->addError('character-error', 'Character already selected!');
                    }
                }
                break;
            case 'brody':
                if ($this->brody === $username) {
                    // de-select
                    $this->brody = null;
                    ($this->game)->update([
                        'brody' => null
                    ]);
                } else {
                    if ($this->brody === null) {
                        $this->brody = $username;
                        ($this->game)->update([
                            'brody' => $user_id
                        ]);
                    } else {
                        // already selected
                        $this->addError('character-error', 'Character already selected!');
                    }
                }
                break;
            case 'hooper':
                if ($this->hooper === $username) {
                    // de-select
                    $this->hooper = null;
                    ($this->game)->update([
                        'hooper' => null
                    ]);
                } else {
                    if ($this->hooper === null) {
                        $this->hooper = $username;
                        ($this->game)->update([
                            'hooper' => $user_id
                        ]);
                    } else {
                        // already selected
                        $this->addError('character-error', 'Character already selected!');
                    }
                }
                break;
            case 'quint':
                if ($this->quint === $username) {
                    // de-select
                    $this->quint = null;
                    ($this->game)->update([
                        'quint' => null
                    ]);
                } else {
                    if ($this->quint === null) {
                        $this->quint = $username;
                        ($this->game)->update([
                            'quint' => $user_id
                        ]);
                    } else {
                        // already selected
                        $this->addError('character-error', 'Character already selected!');
                    }
                }
                break;
        }

        $this->deSelect($username, $model);

        if (count($this->getErrorBag()->get('character-error')) === 0) {
            broadcast(new syncCharacterSelection($this->session_id, [
                'shark'  => $this->shark,
                'brody'  => $this->brody,
                'hooper' => $this->hooper,
                'quint'  => $this->quint,
            ]));
        }
    }

    public function syncSelectedCharacters($data) {
        foreach ($data as $model => $username) {
            switch ($model) {
                case 'shark':
                    $this->shark = $username;
                    break;
                case 'brody':
                    $this->brody = $username;
                    break;
                case 'hooper':
                    $this->hooper = $username;
                    break;
                case 'quint':
                    $this->quint = $username;
                    break;
            }
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function render()
    {
        return view('livewire.character-select');
    }
}
