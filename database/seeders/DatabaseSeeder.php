<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gamedock.test'],
            [
                'name' => 'GameDock Admin',
                'country' => 'Indonesia',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            GameSeeder::class,
        ]);
    }
}
