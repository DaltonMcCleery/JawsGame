<?php

namespace App\Traits;

trait ActOneActions {

    /**
     * @param $character
     * @param $actions
     * @param $gameState
     * @return array
     */
    public function parseActions($character, $actions, $gameState) {
        $state_changes = [];

        foreach ($actions[$character] as $action) {
            if (str_contains($action, 'Move')) {
                continue;
            }

            $location = $this->getSpace($action);

            // Swimmers
            if (str_contains($action, 'Eat 1 Swimmer')) {
                // Check for Michael
                if (isset($gameState['michael_position']) && $gameState['michael_position'] === ($location.'_Swimmers')) {
                    $state_changes[$location.'_Swimmers'] = $gameState[$location.'_Swimmers'] - 2;
                    $state_changes['swimmers_eaten'] = $gameState['swimmers_eaten'] + 2;
                    // Reverse changes for continued actions
                    $gameState[$location.'_Swimmers'] = $state_changes[$location.'_Swimmers'];
                    $gameState['swimmers_eaten'] = $state_changes['swimmers_eaten'];
                } else {
                    // Remove Swimmer from Beach
                    $state_changes[$location.'_Swimmers'] = $gameState[$location.'_Swimmers'] - 1;
                    $state_changes['swimmers_eaten'] = $gameState['swimmers_eaten'] + 1;
                    // Reverse changes for continued actions
                    $gameState[$location.'_Swimmers'] = $state_changes[$location.'_Swimmers'];
                    $gameState['swimmers_eaten'] = $state_changes['swimmers_eaten'];
                }
            }

            if (str_contains($action, 'Rescue 1 Swimmer')) {
                // Check for Michael
                if (isset($gameState['michael_position']) && $gameState['michael_position'] === ($location.'_Swimmers')) {
                    $state_changes[$location.'_Swimmers'] = $gameState[$location.'_Swimmers'] - 2;
                    // Reverse changes for continued actions
                    $gameState[$location.'_Swimmers'] = $state_changes[$location.'_Swimmers'];
                } else {
                    // Remove Swimmer from Beach
                    $state_changes[$location.'_Swimmers'] = $gameState[$location.'_Swimmers'] - 1;
                    // Reverse changes for continued actions
                    $gameState[$location.'_Swimmers'] = $state_changes[$location.'_Swimmers'];
                }
            }

            if (str_contains($action, 'Eat all Swimmers')) {
                // Remove ALL Swimmers from Beach
                $state_changes[$location.'_Swimmers'] = 0;
                // Reverse changes for continued actions
                $gameState[$location.'_Swimmers'] = 0;
            }

            // Barrels
            if (str_contains($action, 'Pick up 1 Barrel')) {
                $state_changes['brody_barrels'] = $gameState['brody_barrels'] + 1;
                // Reverse changes for continued actions
                $gameState['brody_barrels'] = $state_changes['brody_barrels'];
            }

            if (str_contains($action, 'Drop 1 Barrel')) {
                $state_changes['brody_barrels'] = $gameState['brody_barrels'] - 1;
                $state_changes[$location.'_barrels'] = $gameState[$location.'_barrels'] + 1;
                // Reverse changes for continued actions
                $gameState['brody_barrels'] = $state_changes['brody_barrels'];
                $gameState[$location.'_barrels'] = $state_changes[$location.'_barrels'];
            }

            if (str_contains($action, 'Pick up any or all Barrels')) {
                $state_changes[$character.'_barrels'] = $gameState[$character.'_barrels'] + $gameState[$location.'_barrels'];
                $state_changes[$location.'_barrels'] = 0;
                // Reverse changes for continued actions
                $gameState[$character.'_barrels'] = $state_changes[$character.'_barrels'];
                $gameState[$location.'_barrels'] = 0;
            }

            if (str_contains($action, 'Give all Barrels to Quint')) {
                $state_changes['quint_barrels'] = $gameState['quint_barrels'] + $gameState[$character.'_barrels'];
                $state_changes[$character.'_barrels'] = 0;
                // Reverse changes for continued actions
                $gameState['quint_barrels'] = $state_changes['quint_barrels'];
                $gameState[$character.'_barrels'] = $state_changes[$character.'_barrels'];
            }

            // Shark Abilities
            if (str_contains($action, 'Feeding Frenzy')) {
                // Remove Swimmer from Beach
                $state_changes[$location.'_Swimmers'] = 0;
                $state_changes['swimmers_eaten'] = $gameState['swimmers_eaten'] + $gameState[$location.'_Swimmers'];
                // Reverse changes for continued actions
                $gameState[$location.'_Swimmers'] = 0;
                $gameState['swimmers_eaten'] = $state_changes['swimmers_eaten'];
            }

            if (str_contains($action, 'Evasive Moves')) {
                $state_changes['ignore_motion_sensors'] = true;
                $gameState['ignore_motion_sensors'] = $state_changes['ignore_motion_sensors'];
            }

            if (str_contains($action, 'Out of Sight')) {
                $state_changes['shark_hidden'] = true;
            }

            // Crew Abilities
            if (str_contains($action, 'Use Binoculars')) {
                $state_changes['binoculars'] = $location;

                if (!$gameState['shark_hidden']) {
                    if ($gameState['shark_position'] === $location) {
                        $state_changes['show_shark'] = true;
                    }
                }
            }

            if (str_contains($action, 'Close a Beach')) {
                $state_changes['closed_beach'] = $location;
                $state_changes['closed_beach_open_in'] = 2;
            }

            if (str_contains($action, 'Use Fish Finder')) {
                $state_changes['fish_finder'] = $location;

                if (!$gameState['shark_hidden']) {
                    if ($gameState['shark_position'] === $location) {
                        $state_changes['show_shark'] = true;
                    }
                    elseif (in_array($gameState['shark_position'], $this->adjacentSpaces[$location])) {
                        $state_changes['shark_nearby'] = true;
                    }
                }
            }

            if (str_contains($action, 'Launch a Barrel')) {
                if ($gameState['shark_position'] === $location) {
                    $state_changes['show_shark'] = true;
                    $state_changes['shark_barrels'] = $gameState['shark_barrels'] + 1;
                    $gameState['shark_barrels'] = $state_changes['shark_barrels'];
                }
            }
        }

        return $state_changes;
    }

    /**
     * @param $action
     * @return string
     */
    private function getSpace($action) {
        $exploded = explode('(', $action);
        return rtrim($exploded[1], ')');
    }

    // -------------------------------------------------------------------------------------------------------------- //

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
