<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'flight_number' => fake()->randomNumber(4, true),
            'departure_city' => fake()->city(),
            'arrival_city' => fake()->city(),
            'departure_time' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d H:i:s'),
            'arrival_time' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d H:i:s'),
        ];
    }
}
