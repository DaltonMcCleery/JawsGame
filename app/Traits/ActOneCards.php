<?php

namespace App\Traits;

use App\Models\Card;

trait ActOneCards {

    public function parseEventCard($card, $gameState) {
        if ($card['type'] === 'Event') {
            return array_merge(
                [
                    'current_event_title' => $card['title'],
                    'current_event_description' => $card['action'],
                    'current_event_swimmers' => $card['description']
                ],
                $this->calculateSwimmerPlacement($card, $gameState),
                $this->determineExtraActions($card['action'], $gameState)
            );
        }

        return null;
    }

    /**
     * @param $description
     * @return int[]
     */
    private function calculateSwimmerPlacement($card, $gameState) {
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
                        $swimmers['North_Beach_Swimmers']++;
                        break;
                    case 'E':
                        $swimmers['East_Beach_Swimmers']++;
                        break;
                    case 'S':
                        $swimmers['South_Beach_Swimmers']++;
                        break;
                    case 'W':
                        $swimmers['West_Beach_Swimmers']++;
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
                                $swimmers['North_Beach_Swimmers']++;
                                break;
                            case 'E':
                                $swimmers['East_Beach_Swimmers']++;
                                break;
                            case 'S':
                                $swimmers['South_Beach_Swimmers']++;
                                break;
                            case 'W':
                                $swimmers['West_Beach_Swimmers']++;
                                break;
                        }
                    }
                }
            }
        }

        return $swimmers;
    }

    private function determineExtraActions($action, $gameState) {
        // Todo
        return [];
    }
}
