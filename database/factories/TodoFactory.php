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
        return [
            'assigned_to' => function ($users) {
                return $users->random()->id;
            },
            'assigned_by' => function ($users) {
                return $users->random()->id;
            },
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending',
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
