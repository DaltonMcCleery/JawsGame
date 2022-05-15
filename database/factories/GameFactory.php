<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id' => Str::random(16),
            'host_id' => User::factory(),
            'status' => 'not started',
            'act' => '1',
        ];
    }
}
