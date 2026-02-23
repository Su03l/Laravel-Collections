<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\Hospital;
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
        // إنشاء مستخدم جديد للدكتور
        $user = User::factory()->create([
            'role' => 'doctor',
            'name' => 'Dr. ' . $this->faker->name(),
        ]);

        return [
            'id' => $user->id, // ربط الدكتور بنفس الـ ID للمستخدم
            'hospital_id' => Hospital::factory(),
            'clinic_id' => Clinic::factory(),
            'name' => $user->name, // استخدام نفس الاسم
            'specialization' => $this->faker->randomElement(['جراحة قلب', 'طب أطفال', 'أسنان', 'جلدية']),
            'bio' => $this->faker->paragraph(),
            'experience_years' => $this->faker->numberBetween(2, 25),
            'image' => 'https://via.placeholder.com/200x200.png?text=Doctor',
            'is_active' => true,
        ];
    }
}
