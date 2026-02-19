<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ar_SA');

        $categories = ['عمل', 'شخصي', 'دراسة', 'أفكار', 'تسوق'];
        $statuses = ['جديد', 'قيد التنفيذ', 'مكتمل', 'معلق'];

        // 1. ملاحظات ثابتة ومميزة
        $fixedNotes = [
            [
                'title' => 'أفكار للمشروع الجديد',
                'content' => "1. تطبيق وصفات بالذكاء الاصطناعي\n2. متتبع المصاريف الشخصية\n3. مساعد تصميم داخلي افتراضي\n4. منصة تبادل لغات",
                'is_pinned' => true,
                'category' => 'عمل',
                'status' => 'قيد التنفيذ',
            ],
            [
                'title' => 'قائمة التسوق',
                'content' => "- حليب\n- بيض\n- خبز توست\n- أفوكادو\n- قهوة مختصة\n- صدور دجاج\n- سبانخ",
                'is_pinned' => false,
                'category' => 'تسوق',
                'status' => 'جديد',
            ],
            [
                'title' => 'اجتماع استراتيجية الربع الثالث',
                'content' => "النقاط الرئيسية:\n- التركيز على الحفاظ على المستخدمين\n- إطلاق حملة تسويقية جديدة في يوليو\n- توظيف 2 مطورين Backend\n- مراجعة توزيع الميزانية",
                'is_pinned' => true,
                'category' => 'عمل',
                'status' => 'معلق',
            ],
        ];

        foreach ($fixedNotes as $note) {
            Note::create($note);
        }

        // 2. توليد باقي الملاحظات لتصل إلى 1000
        for ($i = 0; $i < 1000; $i++) {
            Note::create([
                'title' => $faker->realText(30),
                'content' => $faker->realText(150),
                'is_pinned' => $faker->boolean(10), // 10% فقط مثبتة
                'category' => $faker->randomElement($categories),
                'status' => $faker->randomElement($statuses),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}
