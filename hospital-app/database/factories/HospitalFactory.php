<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hospital>
 */
class HospitalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Hospital', // Random hospital name
            'address' => $this->faker->address(), // Random address
            'city' => $this->faker->randomElement(['الرياض', 'جدة', 'الدمام', 'مكة']),
            'image' => 'https://via.placeholder.com/400x300.png?text=Hospital',
        ];
    }
}
