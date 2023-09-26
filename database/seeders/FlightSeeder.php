<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Flight::factory()
            ->count(50)
            ->create();
            
           // Create passengers and distribute them among flights
        $passengerCount = 1000;
        $flights = Flight::all();

        while ($passengerCount > 0) {
            $flight = $flights->random();
            $passengerCount--;

            Passenger::factory()->create(['flight_id' => $flight->id]);
        }
    }
}
