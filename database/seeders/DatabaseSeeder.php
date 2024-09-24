<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Ademir',
            'role' => 'admin',
            'email' => 'admin@pi.co',
            'password' => '123',
        ]);

        User::factory()->create([
            'name' => 'Conceição',
            'role' => 'contributor',
            'email' => 'contributor@pi.co',
            'password' => '123',
        ]);

        User::factory()->create([
            'name' => 'Colorau',
            'role' => 'collector',
            'email' => 'collector@pi.co',
            'password' => '123',
        ]);
    }
}
