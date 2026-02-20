<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;
use Faker\Factory as Faker;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ar_SA');

        $titles = [
            'شراء مستلزمات البيت',
            'تسليم المشروع للعميل',
            'موعد مع الدكتور',
            'قراءة كتاب',
            'ممارسة الرياضة',
            'تعلم لارافل',
            'تنظيف المكتب',
            'الاتصال بالأهل',
            'دفع الفواتير',
            'شراء هدية',
            'تحضير العرض التقديمي',
            'مراجعة الكود',
            'كتابة تقرير',
            'تصليح السيارة',
            'شراء كتب جديدة'
        ];

        $descriptions = [
            'شراء الخضروات والفواكه والحليب والخبز من السوبرماركت',
            'تسليم مشروع العميل النهائي مع شرح الميزات الجديدة',
            'موعد دوري مع الدكتور الساعة 10 صباحاً',
            'قراءة 50 صفحة من كتاب "العادات الذرية"',
            'تمارين كارديو لمدة 30 دقيقة في النادي',
            'مشاهدة فيديوهات عن Inertia.js مع React',
            'ترتيب المكتب ورمي الأوراق القديمة',
            'الاتصال بالوالدين والاطمئنان عليهم',
            'دفع فاتورة الكهرباء والإنترنت والماء',
            'شراء هدية عيد ميلاد لصديق',
            'تجهيز عرض PowerPoint للاجتماع الأسبوعي',
            'مراجعة الكود واصلاح الأخطاء',
            'كتابة تقرير الأداء الشهري',
            'تغيير زيت السيارة وفحص الإطارات',
            'شراء روايات جديدة من المعرض'
        ];

        $priorities = ['low', 'medium', 'high'];

        for ($i = 1; $i <= 12; $i++) {
            $completed = $faker->boolean(30); // 30% احتمال تكون مكتملة

            Todo::create([
                'title' => $faker->randomElement($titles),
                'description' => $faker->randomElement($descriptions) . ' ' . $faker->sentence(5),
                'completed' => $completed,
                'priority' => $faker->randomElement($priorities),
                'due_date' => $faker->optional(0.7)->dateTimeBetween('now', '+1 month'), // 70% احتمال يكون لها تاريخ
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
