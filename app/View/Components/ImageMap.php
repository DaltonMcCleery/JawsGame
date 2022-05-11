<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageMap extends Component
{
    private string $yellow = '#ffff0038';
    private string $red = '#ff000038';

    private string $pulse = 'animate-pulse';

    public function __construct(
        public array $gameState = [],
        public string $screen = 'player',
        public array $fill = [],
        public array $class = [],
    ) {
        if (isset($gameState['current_selected_action'])) {
            // Starting State
            if ($gameState['current_selected_action'] === 'Starting Position' && $screen === 'player') {
                $this->fill = [
                    'Space_1' => $this->yellow,
                    'Space_2' => $this->yellow,
                    'Space_3' => $this->yellow,
                    'Space_4' => $this->yellow,
                    'Space_5' => $this->yellow,
                    'Space_6' => $this->yellow,
                    'Space_7' => $this->yellow,
                    'Space_8' => $this->yellow,
                    'North_Beach' => $this->yellow,
                    'East_Beach' => $this->yellow,
                    'South_Beach' => $this->yellow,
                    'West_Beach' => $this->yellow,
                    'Shop' => $this->red,
                ];

                $this->class = [
                    'Space_1' => $this->pulse,
                    'Space_2' => $this->pulse,
                    'Space_3' => $this->pulse,
                    'Space_4' => $this->pulse,
                    'Space_5' => $this->pulse,
                    'Space_6' => $this->pulse,
                    'Space_7' => $this->pulse,
                    'Space_8' => $this->pulse,
                    'North_Beach' => $this->pulse,
                    'East_Beach' => $this->pulse,
                    'South_Beach' => $this->pulse,
                    'West_Beach' => $this->pulse,
                    'Shop' => $this->pulse,
                ];
            }
        }

        if (isset($gameState['shark_nearby'])) {
            foreach ($gameState['shark_nearby'] as $space) {
                $this->fill[$space] = $this->red;
                $this->class[$space] = $this->pulse;
            }
        }

        if (isset($gameState['show_shark'])) {
            $this->fill[$gameState['shark_position']] = $this->red;
            $this->class[$gameState['shark_position']] = $this->pulse;
        }
    }

    public function render()
    {
        return view('components.image-map');
    }
}
