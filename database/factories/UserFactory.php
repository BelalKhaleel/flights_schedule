<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'remember_token' => Str::random(10),
        ];
    }

    // public function admin()
    // {
    //     return $this->afterCreating(function ($user) {
    //         // Assign the "admin" role to the user
    //         $adminRole = Role::where('name', 'Admin')->first();
    //         if ($adminRole) {
    //             $user->assignRole($adminRole);
    //         }
    //     });
    // }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
