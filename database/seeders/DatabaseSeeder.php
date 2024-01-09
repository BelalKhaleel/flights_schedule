<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            FlightSeeder::class,
            PassengerSeeder::class,
        ]);

        $passengers = Passenger::all();
        $flights = Flight::all();

        foreach ($passengers as $passenger) {
            // Determine the number of flights to assign to the passenger (random between 1 and 5)
            $flightCount = rand(1, 5);
    
            // Shuffle the flights and take a random set of flights
            $randomFlights = $flights->shuffle()->take($flightCount);
    
            // Attach the passenger to the selected flights
            $passenger->flights()->attach($randomFlights);
        }
    }
}
