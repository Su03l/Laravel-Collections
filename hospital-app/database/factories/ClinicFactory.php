<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clinics = [
            'Cardiology', 'Dermatology', 'Neurology', 'Pediatrics',
            'Orthopedics', 'Ophthalmology', 'Dental', 'Psychiatry',
            'Gynecology', 'Urology'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($clinics),
            'description' => $this->faker->sentence(),
            'icon' => $this->faker->imageUrl(100, 100, 'icon', true),
        ];
    }
}
