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
            'name' => 'Dalton McCleery',
            'username' => 'DaltoSalto',
            'email' => 'daltonmccleery@gmail.com',
            'role' => 'ADMIN',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Taylor Robbins',
            'username' => 'Tay The GOAT',
            'email' => 'taylormrobbins@gmail.com',
            'role' => 'USER',
            'password' => Hash::make('password'),
        ]);
    }
}
