<?php

namespace Database\Factories;

use DateInterval;
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
        $departureTime = $this->faker->dateTimeBetween('-1 year', '+1 year');
        
         // Generate a random number of hours between 1 and 24 (adjust the range as needed)
         $randomHours = $this->faker->numberBetween(1, 19);

         // Create an end date by adding the random number of hours to the departure time
         $endDate = clone $departureTime;
         $endDate->add(new DateInterval("PT{$randomHours}H"));

        return [
            'flight_number' => fake()->randomNumber(4, true),
            'departure_city' => fake()->city(),
            'arrival_city' => fake()->city(),
            'departure_time' => $departureTime->format('Y-m-d H:i:s'),
            'arrival_time' => $endDate->format('Y-m-d H:i:s'),
        ];
    }
}
