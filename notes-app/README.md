<div align="center">

# Sticky Notes

### لوحة ملاحظاتك الذكية.. رتب أفكارك ولا تضيعها!

<p>
    <a href="#"><img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" /></a>
    <a href="#"><img src="https://img.shields.io/badge/React-18-61DAFB?style=for-the-badge&logo=react&logoColor=black" alt="React" /></a>
    <a href="#"><img src="https://img.shields.io/badge/Inertia.js-2.0-9553E9?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia" /></a>
    <a href="#"><img src="https://img.shields.io/badge/Tailwind-3.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind" /></a>
</p>

<br>

**Sticky Notes** هو المكان اللي تجمع فيه شتات أفكارك. بدل ما تكتب في ورقة وتضيع، أو في نوتة الجوال وتنساها، هنا عندك لوحة تحكم كاملة (Dashboard) بتصميم عصري ورايق. تقدر تثبت الملاحظات المهمة، تصنفها ألوان، وتفلترها بضغطة زر. وفوق هذا كله، يدعم الوضع الليلي عشان عيونك ما تتعب في الليل.

</div>

---

## وش السالفة؟ (تفاصيل المشروع)

المشروع هذا مو مجرد تطبيق ملاحظات عادي، هذا "مكتبك الرقمي". صممناه عشان يكون سريع، سلس، وشكله يفتح النفس:
- **لوحة تحكم عصرية**: واجهة مستخدم (UI) نظيفة ومرتبة، تشبه تطبيقات الـ SaaS العالمية.
- **تثبيت الملاحظات (Pin)**: عندك شي مهم؟ ثبته في الأعلى عشان ما يغيب عن عينك.
- **تصنيفات ذكية**: (عمل، شخصي، دراسة، أفكار..) كل شي له لونه ومكانه.
- **فلترة وبحث**: ضيعت ملاحظة؟ اكتب أي كلمة في البحث أو اختر التصنيف وتطلع لك فوراً.
- **وضع ليلي (Dark Mode)**: بضغطة زر، التطبيق يتحول لثيم أسود وبنفسجي (Cyberpunk Style) فخم جداً.
- **تفاعل سلس**: أنيميشن وحركات ناعمة تخلي استخدام التطبيق متعة بحد ذاتها.

---

## التقنيات المستخدمة (Tech Stack)

بنينا هذا المشروع بخلطة سحرية تضمن لك الأداء والسرعة:

- **Laravel 12**: في الباك اند، عشان القوة والأمان وإدارة البيانات.
- **React + TypeScript**: في الفرونت اند، عشان التفاعلية والسرعة وتجربة المستخدم السلسة.
- **Inertia.js**: الجسر اللي يربط بين لارافل ورياكت بدون وجع راس الـ API التقليدي.
- **Tailwind CSS**: عشان التصميم يكون بكسل بيرفكت (Pixel Perfect) ومتجاوب مع كل الشاشات.
- **Framer Motion**: عشان الحركات والأنيميشن اللي تشوفها في البطاقات والقوائم.

---

## كيف تشغله؟ (خطوة بخطوة)

تبي تجرب المشروع عندك؟ اتبع الخطوات هذي وما راح تضيع:

1. **انسخ المشروع:**
```bash
git clone https://github.com/your-username/notes-app.git
cd notes-app
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
*(هذا الأمر بيسوي لك الجداول ويعبي لك 1000 ملاحظة تجريبية عشان تشوف قوة التطبيق!)*

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
افتح المتصفح على `http://localhost:8000` وعيش التجربة.

---

<div align="center">
صنع بـ "روقان" بواسطة المهندس سليمان
</div>
