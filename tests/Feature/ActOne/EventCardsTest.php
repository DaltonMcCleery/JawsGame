<?php

namespace Tests\Feature\ActOne;

use App\Http\Livewire\Game\Monitor\GameActOne;
use App\Models\Card;
use App\Models\Game;
use Database\Seeders\EventCardSeeder;
use Livewire\Livewire;
use Tests\TestCase;

class EventCardsTest extends TestCase
{
    public ?Card $card = null;

    private function createCard(string $title): void
    {
        collect((new EventCardSeeder())->cards)
            ->each(function ($data, $key) use ($title) {
                if ($data['title'] === $title) {
                    $this->card = Card::create([
                        'type' => 'Event',
                        'title' => $data['title'],
                        'image' => $data['image'],
                        'description' => $data['description'],
                        'token' => 'event-'.($key+1).'-card',
                        'action' => $data['action']
                    ]);
                }
            });
    }

    private function setUpGameState(): array
    {
        return [
            // Crew Starting Positions & Equipped Barrels
            'quint_barrels'           => 2,
            'quint_moves'             => 4,
            'quint_position'          => 'Space_8',
            'quint_last_position'     => 'Space_8',
            'hooper_barrels'          => 0,
            'hooper_moves'            => 4,
            'hooper_position'         => 'Space_5',
            'hooper_last_position'    => 'Space_5',
            'brody_barrels'           => 0,
            'brody_moves'             => 4,
            'brody_position'          => 'Space_7',
            'brody_last_position'     => 'Space_7',
            // Barrels
            'Shop_barrels'            => 6,
            'Space_5_barrels'         => 0,
            'Space_8_barrels'         => 0,
            // Beach Swimmers
            'North_Beach_Swimmers'    => 0,
            'East_Beach_Swimmers'     => 0,
            'South_Beach_Swimmers'    => 0,
            'West_Beach_Swimmers'     => 0,
            'closed_beach'            => 'none',
            // Shark starting elements
            'shark_barrels'           => 0,
            'shark_moves'             => 3,
            'shark_position'          => 'Space_1',
            'shark_last_position'     => 'Space_1',
            'swimmers_eaten'          => 0,
            'ignore_motion_sensors'   => false,
            'locked_closed_beach'     => false,
            // Act I
            'active_player'           => 'monitor',
            'active_character'        => 'shark',
            'current_description'     => 'Playing Event Card...',
            'current_phase'           => 'Event',
            'current_selected_action' => null,
            'play_event_card' => 'Event',
            // Abilities
            'shark_hidden'            => false,
            'binoculars'              => null,
            'fish_finder'             => null,
            'show_shark'              => false,
            'shark_nearby'            => [],
            'used_feeding_frenzy'     => false,
            'used_out_of_sight'       => false,
            'used_speed_burst'        => false,
            'used_evasive_moves'      => false,
            // Enhancements
            'audio'                   => null,
            'video'                   => null,
        ];
    }

    private function gameStateContains(array $expected, array $gameState): void
    {
        foreach ($expected as $key => $value) {
            $this->assertTrue(isset($gameState[$key]));
            $this->assertTrue($gameState[$key] === $value);
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    /**
     * @group events
     * @dataProvider eventCardProvider
     */
    public function test_card($title, $data)
    {
        $this->createCard($title);

        $component = Livewire::test(GameActOne::class, [
            'game' => Game::factory()->create(),
            'gameState' => $this->setUpGameState(),
        ])
            ->call('playEventCard', $this->card);

        $this->gameStateContains(array_merge($data, [
            'current_event_title' => $title,
            'current_event_description' => $this->card->action,
            'current_event_swimmers' => $this->card->description,
        ]), $component->get('localGameState'));
    }

    protected function eventCardProvider(): array
    {
        return [
            'Ben Gardner\'s Boat' => ['Ben Gardner\'s Boat', [
                'North_Beach_Swimmers' => 2,
                'East_Beach_Swimmers' => 0,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 2,
            ]],
            'Amity Island in the News' => ['Amity Island in the News', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 2,
                'South_Beach_Swimmers' => 2,
                'West_Beach_Swimmers' => 0,
                'extra_crew_move' => 1,
            ]],
            'Holiday Roast' => ['Holiday Roast', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 0,
                'West_Beach_Swimmers' => 2,
            ]],
            'Mayor Vaughn Steps In' => ['Mayor Vaughn Steps In', [
                'North_Beach_Swimmers' => 2,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 2,
                'West_Beach_Swimmers' => 1,
            ]],
            'Caught the Wrong Shark' => ['Caught the Wrong Shark', [
                'North_Beach_Swimmers' => 0,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 1,
            ]],
            'The Fourth of July' => ['The Fourth of July', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 1,
            ]],
            'Michael Brody\'s Birthday' => ['Michael Brody\'s Birthday', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 2,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 0,
            ]],
            'Frank Silva Harbor Master' => ['Frank Silva Harbor Master', [
                'North_Beach_Swimmers' => 2,
                'East_Beach_Swimmers' => 0,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 2,
            ]],
            '$3,000 Bounty on the Shark' => ['$3,000 Bounty on the Shark', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 2,
                'South_Beach_Swimmers' => 2,
                'West_Beach_Swimmers' => 1,
            ]],
            'The USS Indianapolis' => ['The USS Indianapolis', [
                'North_Beach_Swimmers' => 0,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 2,
                'West_Beach_Swimmers' => 2,
            ]],
            'Shark Alert! #1' => ['Shark Alert! #1', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 2,
                'West_Beach_Swimmers' => 2,
            ]],
            'Cardboard Fin Hoax' => ['Cardboard Fin Hoax', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 1,
            ]],
            'Shark Alert! #2' => ['Shark Alert! #2', [
                'North_Beach_Swimmers' => 1,
                'East_Beach_Swimmers' => 2,
                'South_Beach_Swimmers' => 2,
                'West_Beach_Swimmers' => 1,
            ]],
            'Shark Alert! #3' => ['Shark Alert! #3', [
                'North_Beach_Swimmers' => 2,
                'East_Beach_Swimmers' => 1,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 2,
            ]],
            'Shark Alert! #4' => ['Shark Alert! #4', [
                'North_Beach_Swimmers' => 2,
                'East_Beach_Swimmers' => 2,
                'South_Beach_Swimmers' => 1,
                'West_Beach_Swimmers' => 1,
            ]],
            'Helicopter' => ['Helicopter', [
                'North_Beach_Swimmers' => 2,
                'East_Beach_Swimmers' => 2,
                'South_Beach_Swimmers' => 0,
                'West_Beach_Swimmers' => 1,
            ]],
        ];
    }
}
