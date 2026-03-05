<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء حساب المدير (Admin)
        User::create([
            'first_name' => 'مدير',
            'last_name' => 'النظام',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), // الباسورد: password
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 2. إنشاء هاشتاقات تقنية عربية
        $tags = ['لارافيل', 'برمجة', 'تطوير الويب', 'أمن سيبراني', 'ذكاء اصطناعي', 'رياكت', 'قواعد بيانات'];
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::create([
                'name' => $tagName,
                'slug' => str_replace(' ', '-', $tagName)
            ]);
            $tagIds[] = $tag->id;
        }

        $this->command->info('تم إنشاء الأدمن والهاشتاقات... جاري توليد 200 مستخدم و 2000 مقال (قد يستغرق بضع ثواني) ⏳');

        // 3. إنشاء 200 يوزر، وكل يوزر له 10 مقالات
        User::factory(200)->create()->each(function ($user) use ($tagIds) {

            // إنشاء 10 مقالات لكل يوزر
            Post::factory(10)->create(['user_id' => $user->id])->each(function ($post) use ($tagIds, $user) {

                // ربط كل مقال بـ هاشتاقين عشوائية
                // نستخدم array_rand للحصول على مفاتيح عشوائية، ثم نستخدم تلك المفاتيح للحصول على الـ IDs
                $randomKeys = array_rand($tagIds, 2);
                $randomTagIds = [$tagIds[$randomKeys[0]], $tagIds[$randomKeys[1]]];
                $post->tags()->attach($randomTagIds);

                // إضافة تعليق عربي عشوائي للمقال من يوزر عشوائي
                // بما أننا في طور الإنشاء، قد لا يكون هناك 200 مستخدم بعد، لذا نستخدم معرف المستخدم الحالي أو عشوائي في حدود ما تم إنشاؤه
                // لكن لتبسيط الأمر وضمان العمل، سنستخدم معرف المستخدم الحالي كصاحب التعليق أو رقم عشوائي صغير
                 Comment::create([
                    'user_id' => rand(1, $user->id), // تعليق من مستخدم موجود (على الأغلب)
                    'post_id' => $post->id,
                    'content' => fake('ar_SA')->realText(50),
                ]);
            });
        });

        $this->command->info('✅ تمت العملية بنجاح! تم إنشاء 2000 مقال تقني عربي.');
    }
}
