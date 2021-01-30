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
     * @param $localGameState
     * @return array
     */
    public function isValidAction($character, $action, $space, $currentActionState, $gameState, $localGameState): array {
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
            if (!in_array($action, $characterActions)) {
                return ['Invalid Action given: "'.$action.'"'];
            }

            return array_merge(
                $this->isNotOutOfMoves($character, $currentActionState, $gameState),
                $this->isMoveAdjacent($character, $action, $space, $currentActionState, $gameState),
                $this->isAbilityMove($character, $action, $space, $currentActionState, $gameState),
                $this->isSwimmerAction($character, $action, $space, $gameState, $localGameState),
                $this->isBarrelAction($character, $action, $space, $currentActionState, $gameState, $localGameState)
            );
        }

        return ['Invalid Character'];
    }

    private function isNotOutOfMoves($character, $currentActionState, $gameState): array {

        if ($character !== 'shark' && $gameState['free_docks'] === "true") {
            foreach ($currentActionState as $key => $action) {
                // Remove any Dock actions temporarily
                if (str_contains($action, 'Drop 1 Barrel') || str_contains($action, 'Pick up any or all Barrels')) {
                    unset($currentActionState[$key]);
                }
            }
        }

        if (count($currentActionState) >= $gameState[$character.'_moves']) {
            return ['Out of Moves'];
        }

        return [];
    }

    private function isMoveAdjacent($character, $action, $space, $currentActionState, $gameState): array {
        if (str_contains($action, 'Move')) {
            if ($character === 'brody') {
                if (!in_array($space, $this->adjacentSpaces[$gameState[$character.'_position']])) {
                    return ['Spaces not adjacent'];
                }
            }
            else {
                // Everyone else is on Water spaces
                if (!in_array($space, $this->adjacentWaterSpaces[$gameState[$character.'_position']])) {
                    if ($character === 'hooper') {
                        // Check if 2 spaces were moved
                        $last_position_adjacent_spaces = $this->adjacentWaterSpaces[$gameState['hooper_position']];
                        $new_position_adjacent_spaces  = $this->adjacentWaterSpaces[$space];

                        // See if they have a common Space between them
                        $common_spaces = array_intersect($last_position_adjacent_spaces, $new_position_adjacent_spaces);
                        if (count($common_spaces) < 1) {
                            return ['Spaces not connected'];
                        } else {
                            // Allow it
                            return [];
                        }
                    }

                    return ['Spaces not adjacent'];
                }

                return [];
            }
        }

        return [];
    }

    public function isAbilityMove($character, $action, $space, $currentActionState, $gameState): array {
        // Shark
        if ($character === 'shark') {
            if (str_contains($action, 'Feeding Frenzy')) {
                // Only can be used once per game
                if ($gameState['used_feeding_frenzy'] === true) {
                    return ['Already used Ability'];
                }
                // Character must be at a beach
                if (!in_array($gameState['shark_position'], $this->beaches)) {
                    return ['Cannot use Ability outside of a Beach'];
                }
                if ($gameState['shark_position'] !== $space) {
                    return ['Cannot use Ability on a different Beach'];
                }
            }

            if (str_contains($action, 'Evasive Moves')) {
                // Only can be used once per game
                if ($gameState['used_evasive_moves'] === true) {
                    return ['Already used Ability'];
                }
            }

            if (str_contains($action, 'Out of Sight')) {
                // Only can be used once per game
                if ($gameState['used_out_of_sight'] === true) {
                    return ['Already used Ability'];
                }
            }

            if (str_contains($action, 'Speed Burst')) {
                // Only can be used once per game
                if ($gameState['used_speed_burst'] === true) {
                    return ['Already used Ability'];
                }

                $last_position_adjacent_spaces = $this->adjacentWaterSpaces[$gameState['shark_position']];
                $new_position_adjacent_spaces = $this->adjacentWaterSpaces[$space];

                // Can only move a TOTAL of 3 Spaces in 1 Action
                foreach ($new_position_adjacent_spaces as $possible_spaces) {
                    $common_spaces = array_intersect($last_position_adjacent_spaces, $this->adjacentWaterSpaces[$possible_spaces]);
                    if (count($common_spaces) < 1) {
                        return [];
                    }
                }

                return ['Spaces not connected'];
            }
        }
        // Crew
        else {

            if (str_contains($action, 'Close a Beach')) {
                // Must be at HQ and in the space the character is currently in
                if (!in_array($gameState['brody_position'], $this->hq)) {
                    return ['Must be at Space 6 or 7 to use Ability'];
                }
                if (!in_array($space, $this->beaches)) {
                    return ['Must Close one of the Beach Spaces'];
                }
                // Cannot use more than once per round
                if ($this->oncePerRound($action, $currentActionState)) {
                    return ['Already used Ability this turn'];
                }
                // Beach must be empty of Swimmers
                if ($gameState[$space.'_Swimmers'] !== 0) {
                    return ['Beach must be empty to Close'];
                }
            }

            if (str_contains($action, 'Use Binoculars')) {
                // Must be at a beach and in the space the character is currently in
                if (!in_array($gameState['brody_position'], $this->beaches)) {
                    return ['Must be at a Beach to use Ability'];
                }
                if ($gameState['brody_position'] !== $space) {
                    return ['Must use Ability in Character\'s current Space'];
                }
                // Cannot use more than once per round
                if ($this->oncePerRound($action, $currentActionState)) {
                    return ['Already used Ability this turn'];
                }
            }

            if (str_contains($action, 'Use Fish Finder')) {
                // Must be used in the space the character is currently in
                if ($gameState['hooper_position'] !== $space) {
                    return ['Must use Ability in Character\'s Space'];
                }
                // Cannot use more than once per round
                if ($this->oncePerRound($action, $currentActionState)) {
                    return ['Already used Ability this turn'];
                }
            }

            if (str_contains($action, 'Launch a Barrel')) {
                // Must have a barrel in inventory
                if ($gameState['quint_barrels'] < 1) {
                    return ['No barrels in Inventory'];
                }
                // Launched Barrel must be adjacent to character
                if (!in_array($space, $this->adjacentWaterSpaces[$gameState['quint_position']])) {
                    return ['Must Launch a Barrel into an adjacent Water Space'];
                }
            }
        }

        return [];
    }

    public function isSwimmerAction($character, $action, $space, $gameState, $localGameState): array {
        if (str_contains($action, 'Swimmer')) {
            if ($gameState[$character.'_position'] !== $space) {
                return ['Character must be in the same Space as the Action'];
            }
            if (!in_array($space, $this->beaches)) {
                return ['Action must be done at a Beach'];
            }
            if ($localGameState[$space.'_Swimmers'] < 1) {
                return ['No Swimmers left at Beach'];
            }
            if ($localGameState[$space.'_Swimmers'] === 2 && $gameState['michael_position'] === $space && $character !== 'brody') {
                return ['Only Brody may save Michael'];
            }
        }

        return [];
    }

    public function isBarrelAction($character, $action, $space, $currentActionState, $gameState, $localGameState): array {

        if ($character !== 'shark') {
            if ($character === 'brody') {
                // Picking up Barrels at Shop or Docks
                if (str_contains($action, 'Pick up 1 Barrel')) {
                    if ($gameState['brody_position'] !== $space) {
                        return ['Character must be in the same Space as Action'];
                    }
                    if (!in_array($gameState['brody_position'], $this->docks) && $gameState['brody_position'] !== 'Shop') {
                        return ['Must be at a Dock or the Shop'];
                    }
                    if ($gameState[$gameState['brody_position'].'_barrels'] < 1) {
                        return ['No Barrels at Space'];
                    }
                }

                // Dropping Barrels at Docks
                if (str_contains($action, 'Drop 1 Barrel')) {
                    if (!in_array($gameState['brody_position'], $this->docks)) {
                        return ['Must be at a Dock'];
                    }
                    if ($gameState['brody_position'] !== $space) {
                        return ['Character must be in same Space as Action'];
                    }
                    if ($localGameState['brody_barrels'] < 1) {
                        return ['No Barrels to drop'];
                    }
                    if ($gameState['free_docks'] === 'locked') {
                        return ['Event Card has locked access to dropping Barrels at Docks'];
                    }
                }
            }

            if ($character === 'hooper') {
                // Picking up Barrels at Docks
                if (str_contains($action, 'Pick up any or all Barrels')) {
                    if (!in_array($gameState['hooper_position'], $this->docks)) {
                        // Pick up barrels from the water
                        if (isset($gameState[$gameState['hooper_position'].'_barrels'])) {
                            if ($gameState[$gameState['hooper_position'].'_barrels'] < 1) {
                                return ['Space has no Barrels'];
                            }
                        }

                        return ['Must be at a Dock'];
                    }
                    if ($gameState['hooper_position'] !== $space) {
                        return ['Character must be in same Space as Action'];
                    }
                    if (isset($gameState[$gameState['hooper_position'].'_barrels'])) {
                        if ($gameState[$gameState['hooper_position'].'_barrels'] < 1) {
                            return ['Space has no Barrels'];
                        }
                    }
                    if ($gameState['free_docks'] === 'locked') {
                        return ['Event Card has locked access to dropping Barrels at Docks'];
                    }
                }

                // Giving Barrels to Quint
                if (str_contains($action, 'Give all Barrels to Quint')) {
                    if ($gameState['hooper_position'] !== $gameState['quint_position']) {
                        return ['Must be in the same Space as Quint'];
                    }
                    if ($localGameState['hooper_barrels'] < 1) {
                        return ['No Barrels to give'];
                    }
                }
            }

            if ($character === 'quint') {
                // Picking up Barrels from Docks
                if (str_contains($action, 'Pick up any or all Barrels')) {
                    if (!in_array($gameState['quint_position'], $this->docks)) {
                        if (isset($gameState[$gameState['quint_position'].'_barrels'])) {
                            if ($gameState[$gameState['quint_position'].'_barrels'] > 0) {
                                return ['Space has no Barrels'];
                            }
                        }

                        return ['Must be at a Dock'];
                    }
                    if ($gameState['quint_position'] !== $space) {
                        return ['Character must be in same Space as Action'];
                    }
                    if ($gameState[$gameState['quint_position'].'_barrels'] < 1) {
                        return ['No Barrels to give'];
                    }
                    if ($gameState['free_docks'] === 'locked') {
                        return ['Event Card has locked access to dropping Barrels at Docks'];
                    }
                }
            }
        }

        return [];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    private function oncePerRound($action, $currentActionState): bool {
        $action = $this->getActionWithoutSpace($action);
        foreach ($currentActionState as $pastAction) {
            if ($this->getActionWithoutSpace($pastAction) === $action) {
                // Already performed action
                return true;
            }
        }

        return false;
    }

    private function getActionWithoutSpace($action): string {
        $exploded = explode(' (', $action);
        return $exploded[0];
    }

    // -------------------------------------------------------------------------------------------------------------- //

    private $sharkActions = [
        'Starting Position',
        'Move 1 Space',
        'Eat 1 Swimmer',
        'Ability Feeding Frenzy',
        'Ability Evasive Moves',
        'Ability Out of Sight',
        'Ability Speed Burst'
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
        'Move 1-2 Spaces',
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
        'Space_5' => [
            'North_Beach',
            'West_Beach',
            'Space_7',
            'Shop'
        ],
        'Space_6' => [
            'North_Beach',
            'East_Beach',
            'South_Beach',
            'Space_8',
            'Shop'
        ],
        'Space_7' => [
            'South_Beach',
            'West_Beach',
            'Space_5',
            'Shop'
        ],
        'Space_8' => [
            'East_Beach',
            'South_Beach',
            'Space_6'
        ],
        'North_Beach' => [
            'Space_5',
            'Space_6',
            'Shop'
        ],
        'East_Beach' => [
            'Space_6',
            'Space_8'
        ],
        'South_Beach' => [
            'Space_6',
            'Space_7',
            'Space_8',
            'Shop'
        ],
        'West_Beach' => [
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
