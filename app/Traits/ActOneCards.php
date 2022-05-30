<?php

namespace App\Traits;

use App\Models\Card;

trait ActOneCards {

    public function parseEventCard($card, $gameState) {
        if ($card['type'] === 'Event') {
            $swimmer_placements = $this->calculateSwimmerPlacement($card, $gameState);

            return array_merge(
                [
                    'current_event_title' => $card['title'],
                    'current_event_description' => $card['action'],
                    'current_event_swimmers' => $card['description']
                ],
                $swimmer_placements,
                $this->determineExtraActions($card['token'], $gameState, $swimmer_placements)
            );
        }

        return null;
    }

    /**
     * @param $card
     * @param $gameState
     * @return int[]
     */
    private function calculateSwimmerPlacement($card, $gameState): array
    {
        $swimmers = [
            'North_Beach_Swimmers' => 0,
            'East_Beach_Swimmers' => 0,
            'South_Beach_Swimmers' => 0,
            'West_Beach_Swimmers' => 0,
        ];

        $exploded = explode(' ', $card['description']);
        foreach ($exploded as $beach) {
            foreach (str_split($beach) as $letter) {
                switch ($letter) {
                    case 'N':
                        if ($gameState['closed_beach'] !== 'North_Beach') {
                            $swimmers['North_Beach_Swimmers']++;
                        }
                        break;
                    case 'E':
                        if ($gameState['closed_beach'] !== 'East_Beach') {
                            $swimmers['East_Beach_Swimmers']++;
                        }
                        break;
                    case 'S':
                        if ($gameState['closed_beach'] !== 'South_Beach') {
                            $swimmers['South_Beach_Swimmers']++;
                        }
                        break;
                    case 'W':
                        if ($gameState['closed_beach'] !== 'West_Beach') {
                            $swimmers['West_Beach_Swimmers']++;
                        }
                        break;
                }
            }
        }

        if (str_contains($card['action'], 'also place:')) {
            if ($gameState['swimmers_eaten'] <= 3) {
                $exploded  = explode(': ', $card['action']);
                $exploded2 = explode(' ', $exploded[count($exploded) - 1]);
                foreach ($exploded2 as $beach) {
                    foreach (str_split($beach) as $letter) {
                        switch ($letter) {
                            case 'N':
                                if ($gameState['closed_beach'] !== 'North_Beach') {
                                    $swimmers['North_Beach_Swimmers']++;
                                }
                                break;
                            case 'E':
                                if ($gameState['closed_beach'] !== 'East_Beach') {
                                    $swimmers['East_Beach_Swimmers']++;
                                }
                                break;
                            case 'S':
                                if ($gameState['closed_beach'] !== 'South_Beach') {
                                    $swimmers['South_Beach_Swimmers']++;
                                }
                                break;
                            case 'W':
                                if ($gameState['closed_beach'] !== 'West_Beach') {
                                    $swimmers['West_Beach_Swimmers']++;
                                }
                                break;
                        }
                    }
                }
            }
        }

        return $swimmers;
    }

    /**
     * @param $token
     * @param $gameState
     * @param $swimmer_placements
     * @return null[]
     */
    private function determineExtraActions($token, $gameState, $swimmer_placements): array
    {
        $possibleChanges = [];

        switch ($token) {
            case 'event-1-card':
                // "If the Shark moves though a boat, they may knock the boat's captain into the water"
                $possibleChanges['captain_down'] = true;
                $possibleChanges['in_water'] = [];
                break;
            case 'event-2-card':
                // "Any one Crew Member may take one extra action this round"
                $possibleChanges['extra_crew_move'] = 1;
                break;
            case 'event-3-card':
                // "Barrels cannot be dropped at or picked up from either Dock this round"
                $possibleChanges['free_docks'] = 'locked';
                break;
            case 'event-4-card':
                // "Remove all Swimmers at any one Beach and close that Beach"
                $beaches = $this->sortBeachesBySwimmers($gameState, $swimmer_placements);
                $possibleChanges['closed_beach'] = $beaches[0];
                $possibleChanges[$beaches[0].'_Swimmers'] = 0;
                $possibleChanges['closed_beach_open_in'] = 3;
                break;
            case 'event-5-card':
                // "The Shark gets one extra action this round"
                $possibleChanges['shark_moves'] = 4;

                if ($gameState['Space_5_barrels'] > $gameState['Space_8_barrels']) {
                    $possibleChanges['hooper_position'] = 'Space_5';
                    $possibleChanges['brody_position'] = 'Space_5';
                }
                elseif ($gameState['Space_8_barrels'] > $gameState['Space_5_barrels']) {
                    $possibleChanges['hooper_position'] = 'Space_8';
                    $possibleChanges['brody_position'] = 'Space_8';
                }
                elseif (in_array($gameState['hooper_position'], ['Space_5', 'Space_8'])) {
                    // Move Brody to Hooper
                    $possibleChanges['brody_position'] = $gameState['hooper_position'];
                }
                else {
                    // Random
                    $dock = (collect(['Space_5', 'Space_8']))->random(1)?->first();
                    $possibleChanges['hooper_position'] = $dock;
                    $possibleChanges['brody_position'] = $dock;
                }

                break;
            case 'event-6-card':
                // "Open all Beaches. Beaches cannot be closed this round."
                $possibleChanges['locked_closed_beach'] = true;
                $possibleChanges['closed_beach'] = 'none';
                $possibleChanges['closed_beach_open_in'] = null;
                break;
            case 'event-7-card':
                // "Place Michael at the open Beach with the fewest Swimmers"
                $beaches = $this->sortBeachesBySwimmers($gameState, $swimmer_placements);
                $possibleChanges['michael_position'] = $beaches[count($beaches) - 1];
                break;
            case 'event-8-card':
                // "Dropping a Barrel at a Dock, or picking up Barrels at a Dock are free actions this round"
                $possibleChanges['free_docks'] = 'true';
                break;
            case 'event-9-card':
                // "Hooper may take one extra action this round"
                $possibleChanges['hooper_moves'] = 5;
                break;
            case 'event-10-card':
                // "Quint may take one extra action this round"
                $possibleChanges['quint_moves'] = 5;
                break;
            case 'event-12-card':
                // "Move all Crew Members to the Beach with the most Swimmers"
                $beaches = $this->sortBeachesBySwimmers($gameState, $swimmer_placements);
                $possibleChanges['brody_position'] = $beaches[0];
                $possibleChanges['hooper_position'] = $beaches[0];
                $possibleChanges['quint_position'] = $beaches[0];
                break;
            case 'event-16-card':
                // "Brody may immediately move to any space on the island"
                $possibleChanges['brody_relocation'] = 1;
                break;
        }

        return $possibleChanges;
    }

    /**
     * @param $gameState
     * @param $new_swimmers
     * @return string[]
     */
    private function sortBeachesBySwimmers($gameState, $new_swimmers): array
    {
        $Nkey = $gameState['North_Beach_Swimmers'] + $new_swimmers['North_Beach_Swimmers'];
        $Ekey = $gameState['East_Beach_Swimmers'] + $new_swimmers['East_Beach_Swimmers'];
        $Skey = $gameState['South_Beach_Swimmers'] + $new_swimmers['South_Beach_Swimmers'];
        $Wkey = $gameState['West_Beach_Swimmers'] + $new_swimmers['West_Beach_Swimmers'];

        $beaches = [
            $Nkey => 'North_Beach',
            $Ekey => 'East_Beach',
            $Skey => 'South_Beach',
            $Wkey => 'West_Beach',
        ];

        rsort($beaches);

        return $beaches;
    }
}
