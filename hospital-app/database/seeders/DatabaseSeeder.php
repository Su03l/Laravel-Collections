<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0500000001', // تغيير الرقم لتجنب التعارض مع الأدمن
        ]);

        // Create 5 hospitals
        $hospitals = Hospital::factory(5)->create();

        // Create 20 clinics
        $clinics = Clinic::factory(20)->create();

        // Create 50 doctors and assign them randomly
        $doctors = Doctor::factory(50)->create(function () use ($hospitals, $clinics) {
            return [
                'hospital_id' => $hospitals->random()->id,
                'clinic_id' => $clinics->random()->id,
            ];
        });

        // Assign schedules to each doctor
        foreach ($doctors as $doctor) {
            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
            foreach ($days as $day) {
                DoctorSchedule::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '15:30:00',
                ]);
            }
        }
    }
}
