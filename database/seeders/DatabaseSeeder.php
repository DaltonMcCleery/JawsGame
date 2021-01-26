<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Dalton',
            'username' => 'DaltoSalto',
            'email' => 'dalton@test.com',
            'role' => 'ADMIN',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Taylor',
            'username' => 'Tay The GOAT',
            'email' => 'taylor@test.com',
            'role' => 'USER',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Haley',
            'username' => 'Rose Gold',
            'email' => 'haley@test.com',
            'role' => 'USER',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Mom',
            'username' => 'LuLu',
            'email' => 'mom@test.com',
            'role' => 'USER',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            EventCardSeeder::class,
            SharkAbilityCardSeeder::class
        ]);
    }
}
