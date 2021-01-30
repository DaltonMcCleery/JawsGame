<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;

class EventCardSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cards = [
            [
                'image' => '',
                'title' => 'Ben Gardner\'s Boat',
                'description' => 'NN S WW',
                'action' => 'If the Shark moves though a boat, they may knock the boat\'s captain into the water. The captain must spend two actions to get back on the boat.'
            ],
            [
                'image' => '',
                'title' => 'Amity Island in the News',
                'description' => 'N SS EE',
                'action' => 'Any one Crew Member may take one extra action this round.'
            ],
            [
                'image' => '',
                'title' => 'Holiday Roast',
                'description' => 'N E WW',
                'action' => 'The Docks are under repair. Barrels cannot be dropped at or picked up from either Dock this round.'
            ],
            [
                'image' => '',
                'title' => 'Mayor Vaughn Steps In',
                'description' => 'NN SS E W',
                'action' => 'After placing Swimmers, remove all Swimmers at any one Beach and close that Beach.'
            ],
            [
                'image' => '',
                'title' => 'Caught the Wrong Shark',
                'description' => 'S E W',
                'action' => 'Move Brody and Hooper to the same Dock (of the Crew\'s choosing). The Shark gets one extra action this round.'
            ],
            [
                'image' => '',
                'title' => 'The Fourth of July',
                'description' => 'N S E W',
                'action' => 'Before placing Swimmers, open all Beaches. Beaches cannot be closed this round.'
            ],
            [
                'image' => '',
                'title' => 'Michael Brody\'s Birthday',
                'description' => 'N S EE',
                'action' => 'Place Michael at the open Beach with the fewest Swimmers. He counts as 2 Swimmers if eaten. Only Chief Brody can rescue him.'
            ],
            [
                'image' => '',
                'title' => 'Frank Silva Harbor Master',
                'description' => 'NN S WW',
                'action' => 'Dropping a Barrel at a Dock, or picking up Barrels at a Dock are free actions this round.'
            ],
            [
                'image' => '',
                'title' => '$3,000 Bounty on the Shark',
                'description' => 'N SS EE W',
                'action' => 'Hooper may take one extra action this round'
            ],
            [
                'image' => '',
                'title' => 'The USS Indianapolis',
                'description' => 'SS E WW',
                'action' => 'Quint may take one extra action this round'
            ],
            [
                'image' => '',
                'title' => 'Shark Alert!',
                'description' => 'S WW',
                'action' => 'If the Shark\'s Swimmer Track is at 3 or lower, also place: N S E'
            ],
            [
                'image' => '',
                'title' => 'Cardboard Fin Hoax',
                'description' => 'N S E W',
                'action' => 'Move all Crew Members to the Beach with the most Swimmers. If tied, the Crew chooses which Beach to go to.'
            ],
            [
                'image' => '',
                'title' => 'Shark Alert!',
                'description' => 'SS E',
                'action' => 'If the Shark\'s Swimmer Track is at 3 or lower, also place: N E W'
            ],
            [
                'image' => '',
                'title' => 'Shark Alert!',
                'description' => 'NN W',
                'action' => 'If the Shark\'s Swimmer Track is at 3 or lower, also place: S E W'
            ],
            [
                'image' => '',
                'title' => 'Shark Alert!',
                'description' => 'N EE',
                'action' => 'If the Shark\'s Swimmer Track is at 3 or lower, also place: N S W'
            ],
            [
                'image' => '',
                'title' => 'Helicopter',
                'description' => 'NN EE W',
                'action' => 'Brody may immediately move to any space on the island'
            ],
        ];

        foreach ($cards as $key => $card) {
             Card::create([
                'type' => 'Event',
                'title' => $card['title'],
                'image' => $card['image'],
                'description' => $card['description'],
                'token' => 'event-'.($key+1).'-card',
                'action' => $card['action']
            ]);
        }
    }
}
