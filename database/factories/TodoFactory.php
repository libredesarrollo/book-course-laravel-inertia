<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{

    public function definition(): array
    {
        $name = $this->faker->name();
        return [
            'name' => $name,
            'count' => 1,
            'user_id' => 1,
        ];
    }
}
