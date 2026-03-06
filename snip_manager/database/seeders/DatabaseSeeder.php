<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Snippet;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. أقسام الباك إند (Backend) ---
        $laravel = Category::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'color' => '#ff2d20',
            'type' => 'backend',
            'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg'
        ]);

        // --- 2. أقسام الفرونت إند (Frontend) ---
        $react = Category::create([
            'name' => 'React',
            'slug' => 'react',
            'color' => '#61dafb',
            'type' => 'frontend',
            'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg'
        ]);

        $css = Category::create([
            'name' => 'CSS UI',
            'slug' => 'css-ui',
            'color' => '#264de4',
            'type' => 'frontend',
            'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-plain.svg'
        ]);

        // --- 3. أقسام قواعد البيانات (Database) ---
        $mysql = Category::create([
            'name' => 'MySQL',
            'slug' => 'mysql',
            'color' => '#4479a1',
            'type' => 'database',
            'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg'
        ]);

        // --- إضافة الأكواد (Snippets) ---
        Snippet::create([
            'category_id' => $laravel->id,
            'title' => 'جلب المستخدمين النشطين',
            'description' => 'استعلام ذكي لجلب المستخدمين النشطين خلال آخر 24 ساعة.',
            'language' => 'php',
            'code' => "User::where('is_active', true)\n    ->where('last_login', '>=', now()->subDay())\n    ->get();"
        ]);

        Snippet::create([
            'category_id' => $react->id,
            'title' => 'هوك التمرير السلس',
            'description' => 'Custom Hook لعمل Scroll سلس للواجهات.',
            'language' => 'javascript',
            'code' => "const useSmoothScroll = () => {\n  window.scrollTo({ top: 0, behavior: 'smooth' });\n};"
        ]);

        Snippet::create([
            'category_id' => $mysql->id,
            'title' => 'البحث بالنص الكامل',
            'description' => 'استعلام Full-Text Search سريع جداً.',
            'language' => 'sql',
            'code' => "SELECT * FROM posts\nWHERE MATCH(title, content) AGAINST('laravel' IN BOOLEAN MODE);"
        ]);

        $this->command->info('✅ تم بناء قاعدة البيانات بالتقسيمات الجديدة والصور بنجاح!');
    }
}
