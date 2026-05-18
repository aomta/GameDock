<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gamedock.test'],
            [
                'name' => 'GameDock Admin',
                'country' => 'Indonesia',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('users')
            ->where('email', 'admin@gamedock.test')
            ->where('role', 'admin')
            ->delete();
    }
};
