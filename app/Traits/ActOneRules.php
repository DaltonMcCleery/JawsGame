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

    private $adjacentSpaces = [
        'Space_1' => [
            'Space_2',
            'Space_3',
            'North_Beach',
            'Space_5'
        ],
        'Space_2' => [
            'Space_1',
            'Space_6',
            'East_Beach',
            'Space_4'
        ],
        'Space_3' => [
            'Space_1',
            'Space_4',
            'West_Beach',
            'Space_7'
        ],
        'Space_4' => [
            'Space_2',
            'Space_3',
            'South_Beach',
            'Space_8'
        ],
        'Space_5' => [
            'Space_1',
            'North_Beach',
            'West_Beach',
            'Space_7',
            'Shop'
        ],
        'Space_6' => [
            'Space_2',
            'North_Beach',
            'East_Beach',
            'South_Beach',
            'Space_8',
            'Shop'
        ],
        'Space_7' => [
            'Space_3',
            'South_Beach',
            'West_Beach',
            'Space_5',
            'Shop'
        ],
        'Space_8' => [
            'Space_4',
            'East_Beach',
            'South_Beach',
            'Space_6'
        ],
        'North_Beach' => [
            'Space_1',
            'Space_5',
            'Space_6',
            'Shop'
        ],
        'East_Beach' => [
            'Space_2',
            'Space_6',
            'Space_8'
        ],
        'South_Beach' => [
            'Space_4',
            'Space_6',
            'Space_7',
            'Space_8',
            'Shop'
        ],
        'West_Beach' => [
            'Space_3',
            'Space_5',
            'Space_7'
        ],
    ];

    /**
     * Determine if a move was valid based on Character rules + Game's State at time of Action
     *
     * @param $character
     * @param $action
     * @param $space
     * @param $currentActionState
     * @param $gameState
     * @return boolean
     */
    public function isValidAction($character, $action, $space, $currentActionState, $gameState) {
        switch ($character) {
            case 'shark':
                if (in_array($action, $this->sharkActions)) {
                    if ($this->isNotOutOfMoves($character, $currentActionState, $gameState)) {
                        if ($this->isMoveAdjacent($character, $action, $space, $currentActionState, $gameState)) {
                            return true;
                        }
                    }
                }

                return false;

            case 'brody':
                if (in_array($action, $this->brodyActions)) {
                    if ($this->isNotOutOfMoves($character, $currentActionState, $gameState)) {
                        if ($this->isMoveAdjacent($character, $action, $space, $currentActionState, $gameState)) {
                            return true;
                        }
                    }
                }

                return false;

            case 'hooper':
                if (in_array($action, $this->hooperActions)) {
                    if ($this->isNotOutOfMoves($character, $currentActionState, $gameState)) {
                        if ($this->isMoveAdjacent($character, $action, $space, $currentActionState, $gameState)) {
                            return true;
                        }
                    }
                }

                return false;

            case 'quint':
                if (in_array($action, $this->quintActions)) {
                    if ($this->isNotOutOfMoves($character, $currentActionState, $gameState)) {
                        if ($this->isMoveAdjacent($character, $action, $space, $currentActionState, $gameState)) {
                            return true;
                        }
                    }
                }

                return false;
        }

        return false;
    }

    private function isNotOutOfMoves($character, $currentActionState, $gameState): bool {
        return (count($currentActionState) < $gameState[$character.'_moves']);
    }

    private function isMoveAdjacent($character, $action, $space, $currentActionState, $gameState): bool {
        if (str_contains($action, 'Move')) {
            if (in_array($space, $this->adjacentSpaces[$gameState[$character.'_position']])) {
                return true;
            }

            return false;
        }

        return true;
    }
}
