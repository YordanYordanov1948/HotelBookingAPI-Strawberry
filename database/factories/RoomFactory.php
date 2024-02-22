<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numberBetween(100, 500),
            'type' => $this->faker->randomElement(['single', 'double', 'suite']),
            'price_per_night' => $this->faker->numberBetween(50, 300),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
        ];
    }
}

