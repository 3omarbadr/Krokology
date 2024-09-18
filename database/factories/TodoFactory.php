<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        $users = User::pluck('id');

        return [
            'assigned_to' => $users->random(),
            'assigned_by' => $users->random(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending',
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
