<?php

namespace App\Traits;

trait ActOneRules {

    private $sharkActions = [
        'Starting Position',
        'Move 1 Space',
        'Eat 1 Swimmer',
        'Use Power Token (Feeding Frenzy)',
        'Eat all Swimmers',
        'Use Power Token (Evasive Moves)',
        'Use Power Token (Out of Sight)',
        'Use Power Token (Speed Burst)',
        'Move 2 Spaces',
        'Move 3 Spaces'
    ];

    private $brodyActions = [
        'Move 1 Space',
        'Rescue 1 Swimmer',
        'Pick up 1 Barrel',
        'Drop 1 Barrel',
        'Use Binoculars',
        'Close a Beach'
    ];

    private $hooperActions = [
        'Move 1 Space',
        'Move 2 Spaces',
        'Rescue 1 Swimmer',
        'Pick up any or all Barrels',
        'Give all Barrels to Quint',
        'Use Fish Finder'
    ];

    private $quintActions = [
        'Move 1 Space',
        'Rescue 1 Swimmer',
        'Pick up any or all Barrels',
        'Launch a Barrel'
    ];

    /**
     * Determine if a move was valid based on Character rules + Game's State at time of Action
     *
     * @param $character
     * @param $action
     * @param $gameState
     * @return boolean
     */
    public function isValidAction($character, $action, $gameState) {
        switch ($character) {
            case 'shark':
                if (in_array($action, $this->sharkActions)) {
                    return true;
                }

                return false;

            case 'brody':
                if (in_array($action, $this->brodyActions)) {
                    return true;
                }

                return false;

            case 'hooper':
                if (in_array($action, $this->hooperActions)) {
                    return true;
                }

                return false;

            case 'quint':
                if (in_array($action, $this->quintActions)) {
                    return true;
                }

                return false;
        }

        return false;
    }
}
