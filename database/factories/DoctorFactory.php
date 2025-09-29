<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'crm'          => $this->faker->unique()->numberBetween(1000, 9999),
            'specialty'    => $this->faker->word(),
            'full_address' => "{$this->faker->streetAddress()}, {$this->faker->numberBetween(1, 1000)}, {$this->faker->city()}",
        ];
    }
}
