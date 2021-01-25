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
            if (str_contains($action, 'Eat 1 Swimmer') || str_contains($action, 'Rescue 1 Swimmer')) {
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
                //
            }

            if (str_contains($action, 'Evasive Moves')) {
                //
            }

            if (str_contains($action, 'Out of Sight')) {
                $state_changes['shark_hidden'] = true;
            }

            if (str_contains($action, 'Speed Burst')) {
                //
            }

            // Crew Abilities
            if (str_contains($action, 'Use Binoculars')) {
                $state_changes['binoculars'] = $location;
            }

            if (str_contains($action, 'Close a Beach')) {
                $state_changes['closed_beach'] = $location;
                $state_changes['closed_beach_open_in'] = 2;
            }

            if (str_contains($action, 'Use Fish Finder')) {
                $state_changes['fish_finder'] = $location;
            }

            if (str_contains($action, 'Launch a Barrel')) {
                //
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
}
