<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{

    public function definition(): array
    {
        // all clinic names
        $clinics = [
            'Cardiology', 'Dermatology', 'Neurology', 'Pediatrics',
            'Orthopedics', 'Ophthalmology', 'Dental', 'Psychiatry',
            'Gynecology', 'Urology'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($clinics), // Random clinic name
            'description' => $this->faker->sentence(), // Random description
            'icon' => $this->faker->imageUrl(100, 100, 'icon', true), // Random image URL1
        ];
    }
}
