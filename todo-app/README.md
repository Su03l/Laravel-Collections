<div align="center">

# Todo Master

### لوحة مهامك الخارقة.. رتب يومك بأسلوب Cyberpunk!

<p>
    <a href="#"><img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" /></a>
    <a href="#"><img src="https://img.shields.io/badge/React-18-61DAFB?style=for-the-badge&logo=react&logoColor=black" alt="React" /></a>
    <a href="#"><img src="https://img.shields.io/badge/Inertia.js-2.0-9553E9?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia" /></a>
    <a href="#"><img src="https://img.shields.io/badge/Tailwind-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind" /></a>
    <a href="#"><img src="https://img.shields.io/badge/DnD_Kit-Sortable-000000?style=for-the-badge&logo=dnd&logoColor=white" alt="DnD Kit" /></a>
</p>

<br>

**Todo Master** هو المكان اللي تتحول فيه الفوضى إلى نظام. بتصميم **Glassmorphism** فخم وألوان **Neon Cyan** مشعة، إدارة المهام صارت تجربة بصرية ممتعة. تقدر ترتب مهامك بالسحب والإفلات (Drag & Drop)، تصنفها بألوان، وتفلترها بلمسة زر. وفوق هذا كله، خلفية تفاعلية تتحرك مع الماوس عشان ما تمل وأنت تشتغل!

</div>

---

## وش السالفة؟ (تفاصيل المشروع)

المشروع هذا مو مجرد قائمة مهام عادية، هذا "مركز قيادة" لإنتاجيتك. صممناه عشان يكون سريع، سلس، وشكله يفتح النفس:

- **تصميم زجاجي (Glassmorphism)**: واجهة مستخدم (UI) شفافة وعصرية، مع خلفية داكنة ونقاط تفاعلية.
- **سحب وإفلات (Drag & Drop)**: رتب أولوياتك بيدك! اسحب المهمة وحطها في المكان اللي يناسبك.
- **تصنيفات ملونة (Categories)**: (عمل، شخصي، رياضة..) كل شي له لونه ومكانه، وتقدر تختار أكثر من تصنيف للمهمة الواحدة.
- **فلترة وبحث فوري**: ضيعت مهمة؟ اكتب أي حرف في البحث أو فلتر حسب الأولوية/التصنيف وتطلع لك فوراً.
- **أولويات واضحة**: (High, Medium, Low) بألوان مميزة عشان تعرف وش اللي لازم يخلص أول.
- **تفاعل سلس**: أنيميشن وحركات ناعمة باستخدام Framer Motion تخلي استخدام التطبيق متعة.

---

## التقنيات المستخدمة (Tech Stack)

بنينا هذا المشروع بخلطة سحرية تضمن لك الأداء والسرعة:

- **Laravel 11**: في الباك اند، عشان القوة والأمان وإدارة البيانات والعلاقات (Many-to-Many).
- **React + TypeScript**: في الفرونت اند، عشان التفاعلية والسرعة وتجربة المستخدم السلسة مع Type Safety.
- **Inertia.js**: الجسر اللي يربط بين لارافل ورياكت بدون وجع راس الـ API التقليدي.
- **Tailwind CSS v4**: أحدث إصدار للتصميم، عشان الستايل يكون بكسل بيرفكت (Pixel Perfect).
- **@dnd-kit**: مكتبة قوية جداً للتعامل مع السحب والإفلات بسلاسة.
- **Framer Motion**: عشان الحركات والأنيميشن اللي تشوفها في البطاقات والقوائم والنوافذ المنبثقة.

---

## كيف تشغله؟ (خطوة بخطوة)

تبي تجرب المشروع عندك؟ اتبع الخطوات هذي وما راح تضيع:

1. **انسخ المشروع:**
```bash
git clone https://github.com/your-username/todo-app.git
cd todo-app
```

2. **ثبت مكتبات الباك اند (PHP):**
```bash
composer install
```

3. **ثبت مكتبات الفرونت اند (JS):**
```bash
npm install
```

4. **جهز ملف الإعدادات:**
```bash
cp .env.example .env
php artisan key:generate
```
*(لا تنسى تعدل بيانات قاعدة البيانات في ملف .env)*

5. **ابنِ الجداول والبيانات الوهمية:**
```bash
php artisan migrate:fresh --seed
```
*(هذا الأمر بيسوي لك الجداول ويعبي لك مهام وتصنيفات تجريبية عشان تشوف قوة التطبيق!)*

6. **شغل السيرفرات:**
افتح تيرمينال وشغل لارافل:
```bash
php artisan serve
```
وافتح تيرمينال ثاني وشغل Vite (للفرونت اند):
```bash
npm run dev
```

7. **استمتع!**
افتح المتصفح على `http://localhost:8000/todos` وعيش التجربة.

---

<div align="center">
صنع بـ "روقان" بواسطة المهندس سليمان
</div>
