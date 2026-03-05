<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        // استخدام مكتبة البيانات الوهمية باللغة العربية
        $faker = fake('ar_SA');

        return [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'username' => $faker->unique()->userName() . rand(100, 999), // لضمان عدم التكرار
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // كلمة المرور الموحدة: password
            'role' => 'user',
            'is_active' => true,
            'bio' => 'مطور برمجيات مهتم بالتقنية والذكاء الاصطناعي.',
            'remember_token' => Str::random(10),
        ];
    }
}
