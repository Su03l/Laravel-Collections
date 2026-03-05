<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $faker = fake('ar_SA');

        // كلمات تقنية لتركيب عناوين احترافية
        $techPrefixes = ['أساسيات', 'مقدمة عن', 'كيف تحترف', 'أفضل ممارسات', 'دليلك الشامل في', 'مقارنة بين', 'حلول مشاكل', 'تعلم بناء واجهات بـ'];
        $techKeywords = ['لارافيل', 'رياكت', 'قواعد البيانات', 'بايثون', 'الذكاء الاصطناعي', 'جافاسكريبت', 'أمن المعلومات', 'هندسة البرمجيات', 'تطوير الويب'];
        $techSuffixes = ['للمبتدئين', 'المتقدمة', 'في 2024', 'بسهولة', 'خطوة بخطوة', 'في سوق العمل', 'للشركات'];

        // تركيب العنوان
        $title = $faker->randomElement($techPrefixes) . ' ' . $faker->randomElement($techKeywords) . ' ' . $faker->randomElement($techSuffixes);

        return [
            // استبدال المسافات بشرطات للرابط، وإضافة رقم عشوائي لمنع التكرار
            'title' => $title,
            'slug' => str_replace(' ', '-', $title) . '-' . rand(1000, 9999),
            'content' => $faker->realText(800), // نص عربي عشوائي طويل للمقال
        ];
    }
}
