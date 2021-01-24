<?php

namespace App\Http\Livewire;

use App\Models\Game;
use Livewire\Component;
use App\Traits\ActOneRules;
use Illuminate\Support\Facades\Auth;

class GameActOne extends Component
{
    use ActOneRules;

    public $game;
    public $gameState;
    public $showShark = false;

    public $currentMove = 'Waiting on Shark to pick a starting place';
    public $currentSelectedAction = 'Starting Position';

    /**
     * @var string Current Active Character who is completing their turn
     */
    public $activeCharacter = 'shark';
    public $activePlayer = 'N/A';

    /**
     * @var array Current Active Character's action history
     */
    public $currentActionState = [];

    /**
     * @var array Complete Act I action history by Character, in order of completion
     */
    public $actionHistory = [];

    protected $listeners = ['refreshActOneState'];

    public function mount(Game $game, array $gameState) {
        $this->game = $game;
        $this->gameState = $gameState;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function loadStartingActOneState() {
        $this->activePlayer = $this->game->Shark->User->username;

        $this->emitTo('game-wrapper', 'setGameState', [
            // Starting Positions & Equipped Barrels
            'quint_barrels' => 2,
            'quint_position' => 'Space_8',
            'hooper_barrels' => 0,
            'hooper_position' => 'Space_5',
            'brody_barrels' => 0,
            'brody_position' => 'Space_7',
            'shark_barrels' => 0,
            'shark_position' => null,
            // Barrels
            'shop_barrels' => 6,
            'space_5_barrels' => 0,
            'space_8_barrels' => 0,
            // Beach Swimmers
            'North_Beach_Swimmers' => 0,
            'East_Beach_Swimmers' => 0,
            'South_Beach_Swimmers' => 0,
            'West_Beach_Swimmers' => 0
        ]);
    }

    public function refreshActOneState($newState) {
        $this->gameState = $newState;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setActiveCharacter($character, $moveDescription = null) {
        if (count($this->currentActionState) > 0) {
            $this->setActionHistory();
        }

        $this->activeCharacter = $character;

        if ($moveDescription) {
            $this->currentMove = $moveDescription;
        }

        // Find who's playing that Character
        switch ($character) {
            case 'shark':
                $this->activePlayer = $this->game->Shark->User->username;
                break;

            case 'brody':
                $this->activePlayer = $this->game->Brody->username;
                break;

            case 'hooper':
                $this->activePlayer = $this->game->Hooper->username;
                break;

            case 'quint':
                $this->activePlayer = $this->game->Quint->username;
                break;
        }
    }

    public function setActionState($action, $space) {
        $this->currentActionState[$this->activeCharacter][] = $action.' ('.$space.')';
    }

    public function setActionHistory() {
        $this->actionHistory[] = $this->currentActionState;
        $this->reset('currentActionState');
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function setSharkStartingPosition($position) {
        $this->emitTo('game-wrapper', 'setGameState', [
            'shark_position' => $position
        ]);

        $this->setActiveCharacter('shark', 'Waiting on Shark Player\'s turn');
    }

    public function attemptAction($space) {
        if ($this->activePlayer === Auth::user()->username) {
            if ($this->isValidAction($this->activeCharacter, $this->currentSelectedAction, $this->gameState)) {
                // Do it
                $this->setActionState($this->currentSelectedAction, $space);

                if ($this->currentSelectedAction === 'Starting Position') {
                    // Move on to actual play
                    $this->setSharkStartingPosition($space);
                }
            } else {
                // fail
                $this->addError('action-error', 'Invalid Move');
            }
        } else {
            $this->addError('action-error', 'Not your turn');
        }
    }

    public function switchNextAction($character, $action) {
        if ($this->activePlayer === Auth::user()->username) {
            $this->currentSelectedAction = $action;
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function render()
    {
        return view('livewire.game-act-one');
    }
}
