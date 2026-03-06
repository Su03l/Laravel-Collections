<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Snippet;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // تنظيف الجداول القديمة عشان ما تتكرر البيانات
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Snippet::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================================
        // 1. BACKEND (10 Snippets)
        // ==========================================

        // Laravel Category
        $laravel = Category::create(['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#ff2d20', 'type' => 'backend', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg']);
        $this->addSnippet($laravel, 'Route Grouping', 'تجميع المسارات مع بادئة وميدل وير.', 'php', "Route::prefix('admin')->middleware('auth')->group(function () {\n    Route::get('/dashboard', [AdminController::class, 'index']);\n    Route::post('/settings', [AdminController::class, 'update']);\n});");
        $this->addSnippet($laravel, 'Eloquent Scope', 'سكوب محلي لجلب المستخدمين النشطين فقط.', 'php', "public function scopeActive($query)\n{\n    return $query->where('status', 'active');\n}");
        $this->addSnippet($laravel, 'API Resource', 'تحويل البيانات إلى JSON مخصص للـ API.', 'php', "public function toArray($request)\n{\n    return [\n        'id' => $this->id,\n        'name' => $this->name,\n        'email' => $this->email,\n        'created_at' => $this->created_at->diffForHumans(),\n    ];\n}");
        $this->addSnippet($laravel, 'Model Observer', 'تنفيذ كود تلقائي عند إنشاء مستخدم جديد.', 'php', "public function created(User $user)\n{\n    Mail::to($user)->send(new WelcomeEmail());\n}");

        // Node.js Category
        $node = Category::create(['name' => 'Node.js', 'slug' => 'node', 'color' => '#6cc24a', 'type' => 'backend', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg']);
        $this->addSnippet($node, 'Express Server', 'إعداد سيرفر بسيط باستخدام Express.', 'javascript', "const express = require('express');\nconst app = express();\n\napp.get('/', (req, res) => res.send('Hello World!'));\n\napp.listen(3000, () => console.log('Server running on port 3000'));");
        $this->addSnippet($node, 'Async File Read', 'قراءة الملفات بشكل غير متزامن.', 'javascript', "const fs = require('fs').promises;\n\nasync function readFile() {\n    const data = await fs.readFile('config.json', 'utf8');\n    console.log(JSON.parse(data));\n}");
        $this->addSnippet($node, 'Middleware Auth', 'ميدل وير للتحقق من التوكن.', 'javascript', "const auth = (req, res, next) => {\n    const token = req.header('x-auth-token');\n    if (!token) return res.status(401).send('Access denied.');\n    next();\n};");

        // Python Category
        $python = Category::create(['name' => 'Python', 'slug' => 'python', 'color' => '#3776ab', 'type' => 'backend', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg']);
        $this->addSnippet($python, 'List Comprehension', 'اختصار الكود لإنشاء القوائم.', 'python', "squares = [x**2 for x in range(10)]\n# Output: [0, 1, 4, 9, 16, 25, 36, 49, 64, 81]");
        $this->addSnippet($python, 'FastAPI Route', 'إنشاء مسار API سريع جداً.', 'python', "from fastapi import FastAPI\napp = FastAPI()\n\n@app.get('/items/{item_id}')\ndef read_item(item_id: int, q: str = None):\n    return {'item_id': item_id, 'q': q}");
        $this->addSnippet($python, 'Context Manager', 'فتح الملفات بأمان باستخدام with.', 'python', "with open('data.txt', 'r') as f:\n    content = f.read()\n    print(content)");


        // ==========================================
        // 2. FRONTEND (10 Snippets)
        // ==========================================

        // React Category
        $react = Category::create(['name' => 'React', 'slug' => 'react', 'color' => '#61dafb', 'type' => 'frontend', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg']);
        $this->addSnippet($react, 'useState Hook', 'إدارة الحالة داخل المكون.', 'javascript', "const [count, setCount] = useState(0);\n\nreturn (\n  <button onClick={() => setCount(count + 1)}>\n    Count: {count}\n  </button>\n);");
        $this->addSnippet($react, 'useEffect Fetch', 'جلب البيانات عند تحميل الصفحة.', 'javascript', "useEffect(() => {\n  fetch('/api/data')\n    .then(res => res.json())\n    .then(data => setData(data));\n}, []);");
        $this->addSnippet($react, 'Custom Hook', 'هوك مخصص للتحقق من حجم الشاشة.', 'javascript', "const useWindowSize = () => {\n  const [size, setSize] = useState(window.innerWidth);\n  // Logic here...\n  return size;\n};");
        $this->addSnippet($react, 'Context API', 'مشاركة البيانات بين المكونات.', 'javascript', "const ThemeContext = createContext('light');\n\nfunction App() {\n  return (\n    <ThemeContext.Provider value='dark'>\n      <Toolbar />\n    </ThemeContext.Provider>\n  );\n}");

        // Vue.js Category
        $vue = Category::create(['name' => 'Vue.js', 'slug' => 'vue', 'color' => '#4fc08d', 'type' => 'frontend', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg']);
        $this->addSnippet($vue, 'v-for Loop', 'تكرار العناصر في القائمة.', 'html', "<ul>\n  <li v-for=\"item in items\" :key=\"item.id\">\n    {{ item.text }}\n  </li>\n</ul>");
        $this->addSnippet($vue, 'Computed Property', 'حساب القيم ديناميكياً.', 'javascript', "computed: {\n  fullName() {\n    return `${this.firstName} ${this.lastName}`;\n  }\n}");
        $this->addSnippet($vue, 'Watcher', 'مراقبة تغير المتغيرات.', 'javascript', "watch: {\n  question(newQuestion, oldQuestion) {\n    this.getAnswer();\n  }\n}");

        // Tailwind/CSS Category
        $css = Category::create(['name' => 'Tailwind CSS', 'slug' => 'tailwind', 'color' => '#38b2ac', 'type' => 'frontend', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-plain.svg']);
        $this->addSnippet($css, 'Centering Div', 'توسط العنصر في الشاشة.', 'html', "<div class=\"flex items-center justify-center h-screen bg-gray-100\">\n  <div class=\"p-6 bg-white rounded shadow\">\n    Centered Content\n  </div>\n</div>");
        $this->addSnippet($css, 'Grid Layout', 'شبكة متجاوبة للصور.', 'html', "<div class=\"grid grid-cols-1 md:grid-cols-3 gap-4\">\n  <div class=\"bg-blue-500 h-32\">1</div>\n  <div class=\"bg-blue-500 h-32\">2</div>\n  <div class=\"bg-blue-500 h-32\">3</div>\n</div>");
        $this->addSnippet($css, 'Gradient Text', 'نص بتدرج لوني.', 'html', "<h1 class=\"text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600\">\n  Hello World\n</h1>");


        // ==========================================
        // 3. DATABASE (10 Snippets)
        // ==========================================

        // MySQL Category
        $mysql = Category::create(['name' => 'MySQL', 'slug' => 'mysql', 'color' => '#4479a1', 'type' => 'database', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg']);
        $this->addSnippet($mysql, 'Inner Join', 'ربط جدولين وجلب البيانات المشتركة.', 'sql', "SELECT users.name, orders.amount\nFROM users\nINNER JOIN orders ON users.id = orders.user_id;");
        $this->addSnippet($mysql, 'Create Index', 'تسريع البحث باستخدام الفهرسة.', 'sql', "CREATE INDEX idx_lastname\nON persons (lastname);");
        $this->addSnippet($mysql, 'Group By', 'تجميع البيانات وحساب المجموع.', 'sql', "SELECT country, COUNT(id)\nFROM customers\nGROUP BY country\nHAVING COUNT(id) > 5;");
        $this->addSnippet($mysql, 'Transaction', 'ضمان تنفيذ العمليات معاً.', 'sql', "START TRANSACTION;\nUPDATE account SET balance = balance - 100 WHERE id = 1;\nUPDATE account SET balance = balance + 100 WHERE id = 2;\nCOMMIT;");

        // Redis Category
        $redis = Category::create(['name' => 'Redis', 'slug' => 'redis', 'color' => '#d82c20', 'type' => 'database', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/redis/redis-original.svg']);
        $this->addSnippet($redis, 'Set with Expiry', 'تخزين مفتاح ينتهي بعد 10 ثواني.', 'bash', "SET session:123 'active' EX 10");
        $this->addSnippet($redis, 'Increment', 'زيادة عداد الزيارات.', 'bash', "INCR page_views:home");
        $this->addSnippet($redis, 'List Push', 'إضافة عناصر لقائمة المهام.', 'bash', "LPUSH tasks 'send_email' 'generate_report'");

        // MongoDB Category
        $mongo = Category::create(['name' => 'MongoDB', 'slug' => 'mongo', 'color' => '#47a248', 'type' => 'database', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mongodb/mongodb-original.svg']);
        $this->addSnippet($mongo, 'Find One', 'البحث عن مستند واحد.', 'javascript', "db.users.findOne({ username: 'jdoe' })");
        $this->addSnippet($mongo, 'Aggregation', 'تجميع وحساب البيانات.', 'javascript', "db.orders.aggregate([\n  { $match: { status: 'A' } },\n  { $group: { _id: '$cust_id', total: { $sum: '$amount' } } }\n])");
        $this->addSnippet($mongo, 'Update Many', 'تحديث عدة حقول دفعة واحدة.', 'javascript', "db.users.updateMany(\n  { age: { $lt: 18 } },\n  { $set: { status: 'minor' } }\n)");

        $this->command->info('✅ تم حقن 30 كود برمجي بنجاح (10 Backend, 10 Frontend, 10 Database)!');
    }

    // دالة مساعدة لإضافة الكود بسرعة
    private function addSnippet($category, $title, $desc, $lang, $code)
    {
        Snippet::create([
            'category_id' => $category->id,
            'title' => $title,
            'description' => $desc,
            'language' => $lang,
            'code' => $code
        ]);
    }
}
