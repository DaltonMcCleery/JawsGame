<?php

namespace App\Traits;

trait ActOneRules {

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
                $characterActions = $this->sharkActions;
                break;

            case 'brody':
                $characterActions = $this->brodyActions;
                break;

            case 'hooper':
                $characterActions = $this->hooperActions;
                break;

            case 'quint':
                $characterActions = $this->quintActions;
                break;

            default:
                $characterActions = null;
        }

        if ($characterActions !== null) {
            if (in_array($action, $this->$characterActions)) {
                if ($this->isNotOutOfMoves($character, $currentActionState, $gameState)) {
                    if ($this->isMoveAdjacent($character, $action, $space, $currentActionState, $gameState)) {
                        if ($this->isAbilityMove($character, $action, $space, $currentActionState, $gameState)) {
                            if ($this->isSwimmerAction($character, $action, $space, $currentActionState, $gameState)) {
                                if ($this->isBarrelAction($character, $action, $space, $currentActionState, $gameState)) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
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
            elseif ($character === 'hooper') {
                // Check if 2 spaces were moved
                $last_position_adjacent_spaces = $this->adjacentWaterSpaces[$gameState['hooper_position']];
                $new_position_adjacent_spaces = $this->adjacentWaterSpaces[$space];

                // See if they have a common Space between them
                $common_spaces = array_intersect($last_position_adjacent_spaces, $new_position_adjacent_spaces);
                if (count($common_spaces) > 1) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }

    public function isAbilityMove($character, $action, $space, $currentActionState, $gameState): bool {
        // Shark
        if ($character === 'shark') {
            if (str_contains($action, 'Feeding Frenzy')) {
                // Character must be at a beach
                if (in_array($gameState['shark_position'], $this->beaches)) {
                    // Only can be used once per game
                    if ($gameState['used_feeding_frenzy'] !== true) {
                        return true;
                    }
                }

                return false;
            }

            if (str_contains($action, 'Evasive Moves')) {
                // TODO

                return false;
            }

            if (str_contains($action, 'Out of Sight')) {
                // Only can be used once per game
                if ($gameState['used_out_of_sight'] !== true) {
                    return true;
                }

                return false;
            }

            if (str_contains($action, 'Speed Burst')) {
                $original_position = $gameState['shark_position'];

                // Can only move a TOTAL of 3 Spaces in 1 Action
                // TODO

                return false;
            }
        }
        // Crew
        else {

            if (str_contains($action, 'Close a Beach')) {
                // Must be at HQ and in the space the character is currently in
                if (in_array($gameState['brody_position'], $this->hq) && in_array($space, $this->beaches)) {
                    // Cannot use more than once per round
                    if ($this->oncePerRound($action, $currentActionState)) {
                        // Beach must be empty of Swimmers
                        if ($gameState[$space.'_Swimmers'] === 0) {
                            return true;
                        }
                    }
                }

                return false;
            }

            if (str_contains($action, 'Use Binoculars')) {
                // Must be at a beach and in the space the character is currently in
                if (in_array($gameState['brody_position'], $this->beaches) && $gameState['brody_position'] === $space) {
                    // Cannot use more than once per round
                    if ($this->oncePerRound($action, $currentActionState)) {
                        return true;
                    }
                }

                return false;
            }

            if (str_contains($action, 'Use Fish Finder')) {
                // Must be used in the space the character is currently in
                if ($gameState['hooper_position'] === $space) {
                    // Cannot use more than once per round
                    if ($this->oncePerRound($action, $currentActionState)) {
                        return true;
                    }
                }

                return false;
            }

            if (str_contains($action, 'Launch a Barrel')) {
                // Must have a barrel in inventory
                if ($gameState['quint_barrels'] > 0) {
                    // Launched Barrel must be adjacent to character
                    if (in_array($space, $this->adjacentWaterSpaces[$gameState['quint_position']])) {
                        return true;
                    }
                }

                return false;
            }
        }

        return true;
    }

    public function isSwimmerAction($character, $action, $space, $currentActionState, $gameState): bool {
        if (str_contains($action, 'Swimmer')) {
            if ($gameState[$character.'_position'] === $space && in_array($space, $this->beaches)) {
                if ($gameState[$space.'_Swimmers'] > 0) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }

    public function isBarrelAction($character, $action, $space, $currentActionState, $gameState): bool {

        if ($character !== 'shark') {
            if ($character === 'brody') {
                // Picking up Barrels at Shop or Docks
                if (str_contains($action, 'Pick up 1 Barrel')) {
                    if ($gameState['brody_position'] === $space) {
                        if (in_array($gameState['brody_position'], $this->docks) || $gameState['brody_position'] === 'Shop') {
                            if ($gameState[$gameState['brody_position'].'_barrels'] > 0) {
                                return true;
                            }
                        }
                    }

                    return false;
                }

                // Dropping Barrels at Docks
                if (str_contains($action, 'Drop 1 Barrel')) {
                    if (in_array($gameState['brody_position'], $this->docks) && $gameState['brody_position'] === $space) {
                        if ($gameState['brody_barrels'] > 0) {
                            return true;
                        }
                    }

                    return false;
                }
            }

            if ($character === 'hooper') {
                // Picking up Barrels at Docks
                if (str_contains($action, 'Pick up any or all Barrels')) {
                    if (in_array($gameState['hooper_position'], $this->docks) && $gameState['hooper_position'] === $space) {
                        if ($gameState[$gameState['hooper_position'].'_barrels'] > 0) {
                            return true;
                        }
                    }
                    // Pick up barrels from the water
                    elseif (isset($gameState[$gameState['hooper_position'].'_barrels'])) {
                        if ($gameState[$gameState['hooper_position'].'_barrels'] > 0) {
                            return true;
                        }
                    }

                    return false;
                }

                // Giving Barrels to Quint
                if (str_contains($action, 'Give all Barrels to Quint')) {
                    if ($gameState['hooper_position'] === $gameState['quint_position']) {
                        if ($gameState['hooper_barrels'] > 0) {
                            return true;
                        }
                    }

                    return false;
                }
            }

            if ($character === 'quint') {
                // Picking up Barrels from Docks
                if (str_contains($action, 'Pick up any or all Barrels')) {
                    if (in_array($gameState['quint_position'], $this->docks) && $gameState['quint_position'] === $space) {
                        if ($gameState[$gameState['quint_position'].'_barrels'] > 0) {
                            return true;
                        }
                    }
                    // Pick up barrels from the water
                    elseif (isset($gameState[$gameState['quint_position'].'_barrels'])) {
                        if ($gameState[$gameState['quint_position'].'_barrels'] > 0) {
                            return true;
                        }
                    }

                    return false;
                }
            }
        }

        return true;
    }

    private function oncePerRound($action, $currentActionState) {
        $action = $this->getActionWithoutSpace($action);
        foreach ($currentActionState as $pastAction) {
            if ($this->getActionWithoutSpace($pastAction) === $action) {
                // Already performed action
                return false;
            }
        }

        return true;
    }

    private function getActionWithoutSpace($action) {
        $exploded = explode(' (', $action);
        return $exploded[0];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    private $sharkActions = [
        'Starting Position',
        'Move 1 Space',
        'Eat 1 Swimmer',
        'Feeding Frenzy',
        'Evasive Moves',
        'Out of Sight',
        'Speed Burst'
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

    private $beaches = [
        'North_Beach',
        'East_Beach',
        'South_Beach',
        'West_Beach'
    ];

    private $docks = [
        'Space_5',
        'Space_8'
    ];

    private $hq = [
        'Space_6',
        'Space_7'
    ];

    private $adjacentWaterSpaces = [
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
            'West_Beach'
        ],
        'Space_6' => [
            'Space_2',
            'North_Beach',
            'East_Beach'
        ],
        'Space_7' => [
            'Space_3',
            'South_Beach',
            'West_Beach'
        ],
        'Space_8' => [
            'Space_4',
            'East_Beach',
            'South_Beach'
        ],
        'North_Beach' => [
            'Space_1',
            'Space_5',
            'Space_6'
        ],
        'East_Beach' => [
            'Space_2',
            'Space_6',
            'Space_8'
        ],
        'South_Beach' => [
            'Space_4',
            'Space_7',
            'Space_8'
        ],
        'West_Beach' => [
            'Space_3',
            'Space_5',
            'Space_7'
        ]
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
        'Shop' => [
            'Space_5',
            'Space_6',
            'Space_7',
            'Space_8',
            'North_Beach',
            'South_Beach'
        ],
    ];
}
