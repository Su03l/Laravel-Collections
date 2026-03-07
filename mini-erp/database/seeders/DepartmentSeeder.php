<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'الموارد البشرية',
            'تقنية المعلومات',
            'المحاسبة والمالية',
            'التسويق',
            'المبيعات',
            'الشؤون القانونية',
            'العلاقات العامة',
            'المشتريات',
            'خدمة العملاء',
            'البحث والتطوير',
        ];

        foreach ($departments as $dept) {
            Department::create(['name' => $dept]);
        }
    }
}
