<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;

class SharkAbilityCardSeeder extends Seeder
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
                'title' => 'Extra Strength',
                'description' => '',
                'action' => 'If the Shark damages a Boat Space, the Boat Space is destroyed.'
            ],
            [
                'image' => '',
                'title' => 'Extra Strength',
                'description' => '',
                'action' => 'If the Shark damages a Boat Space, the Boat Space is destroyed.'
            ],
            [
                'image' => '',
                'title' => 'Second Helping',
                'description' => '',
                'action' => 'After an attack that targets the boat, the Shark may launch a second attack on the boat with two dice. The second attack may target the same Boat Space or a different one.'
            ],
            [
                'image' => '',
                'title' => 'Second Helping',
                'description' => '',
                'action' => 'After an attack that targets the boat, the Shark may launch a second attack on the boat with two dice. The second attack may target the same Boat Space or a different one.'
            ],
            [
                'image' => '',
                'title' => 'Maul Again',
                'description' => '',
                'action' => 'After rolling for an attack, the Shark may reroll as many dice as they wish. The new results are final.'
            ],
            [
                'image' => '',
                'title' => 'Maul Again',
                'description' => '',
                'action' => 'After rolling for an attack, the Shark may reroll as many dice as they wish. The new results are final.'
            ],
            [
                'image' => '',
                'title' => 'Big Mouth',
                'description' => '',
                'action' => 'If the Shark damages or destroys a Boat Space, each Crew Member on that Boat Space takes 1 Wound.'
            ],
            [
                'image' => '',
                'title' => 'Big Mouth',
                'description' => '',
                'action' => 'If the Shark damages or destroys a Boat Space, each Crew Member on that Boat Space takes 1 Wound.'
            ],
            [
                'image' => '',
                'title' => 'Ramming Speed',
                'description' => '',
                'action' => 'After teh Crew attacks, the Shark may move to an adjacent Water Space. If the Shark moves, add 2 Hits to their attack roll.'
            ],
            [
                'image' => '',
                'title' => 'Ramming Speed',
                'description' => '',
                'action' => 'After teh Crew attacks, the Shark may move to an adjacent Water Space. If the Shark moves, add 2 Hits to their attack roll.'
            ],
            [
                'image' => '',
                'title' => 'Domino Effect',
                'description' => '',
                'action' => 'If the Shark damages or destroys a Boat Space, apply 2 Hits to one Boat Space that is adjacent to the targeted Boat Space.'
            ],
            [
                'image' => '',
                'title' => 'Domino Effect',
                'description' => '',
                'action' => 'If the Shark damages or destroys a Boat Space, apply 2 Hits to one Boat Space that is adjacent to the targeted Boat Space.'
            ],
            [
                'image' => '',
                'title' => 'Hard Target',
                'description' => '',
                'action' => 'The Shark\'s Evade value is 3. Crew Gear cards that affect Evade values are still active.'
            ],
            [
                'image' => '',
                'title' => 'Hard Target',
                'description' => '',
                'action' => 'The Shark\'s Evade value is 3. Crew Gear cards that affect Evade values are still active.'
            ],
            [
                'image' => '',
                'title' => 'Making Waves',
                'description' => '',
                'action' => 'If the Shark damages or destroys a Boat Space, all Crew Members anywhere on the boat fall into the Water Space in their zone.'
            ],
            [
                'image' => '',
                'title' => 'Making Waves',
                'description' => '',
                'action' => 'If the Shark damages or destroys a Boat Space, all Crew Members anywhere on the boat fall into the Water Space in their zone.'
            ],
        ];

        foreach ($cards as $key => $card) {
            Card::create([
                'type' => 'Shark Ability',
                'image' => $card['image'],
                'description' => $card['description'],
                'token' => 'shark-ability-'.($key+1).'-card',
                'action' => $card['action']
            ]);
        }
    }
}
