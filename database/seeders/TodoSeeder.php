<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        $users = User::all();

        Todo::factory()->count(1000)->create([
            'assigned_by' => fn() => $users->random()->id,
            'assigned_to' => fn() => $users->random()->id,
        ]);
    }
}
