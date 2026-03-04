# Medical Appointment Booking API - الخادم الخلفي

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-003B57?style=for-the-badge&logo=mysql)
![Sanctum](https://img.shields.io/badge/Auth-Sanctum-38BDF8?style=for-the-badge&logo=laravel)
![Redis](https://img.shields.io/badge/Queue-Redis-DC382D?style=for-the-badge&logo=redis)

**نظام إدارة المواعيد والسجلات الطبية الذكي (Enterprise Level)**

---

## نظرة عامة

"Medical Appointment Booking API" هو نظام خلفي (Backend) متكامل ومبني بمعايير برمجية عالية لإدارة العيادات والمستشفيات. يهدف النظام إلى أتمتة دورة حياة المريض بالكامل، بدءاً من حجز الموعد، مروراً بالكشف الطبي، وصولاً إلى استلام التقارير والروشتات إلكترونياً، مع ضمان أعلى معايير الخصوصية والأمان للبيانات الطبية.

## المشكلات التي يحلها النظام

| المشكلة | الحل التقني المطبق |
| :--- | :--- |
| **تضارب المواعيد** | خوارزمية Atomic Locks و Transactions لمنع الحجز المزدوج في نفس الثانية. |
| **خصوصية البيانات** | نظام تخزين محمي Private Storage يمنع الوصول المباشر للملفات عبر الروابط العامة. |
| **المواعيد المنسية** | روبوتات Cron Jobs تقوم بتنظيف المواعيد الفائتة وتحديث حالتها تلقائياً كل ساعة. |
| **التقييمات الوهمية** | نظام Review Policy يمنع التقييم إلا بعد إتمام الكشف الطبي وتغير حالة الموعد إلى completed. |
| **أمان الملفات** | روابط مؤقتة Temporary URLs للمرفقات الطبية تنتهي صلاحيتها تلقائياً. |

---

## التقنيات المستخدمة

- **الإطار العمل:** Laravel 11
- **قاعدة البيانات:** MySQL
- **المصادقة:** Laravel Sanctum (Token Based)
- **الحماية:** Role-Based Access Control (RBAC) Middleware
- **التخزين:** Local Private Disk (Simulating S3 Security)
- **التقارير:** DomPDF لتوليد الروشتات
- **الأتمتة:** Task Scheduling & Commands

---

## طريقة التثبيت والتشغيل

1. **استنساخ المستودع:**
   ```bash
   git clone https://github.com/your-repo/hospital-app.git
   cd hospital-app
   ```

2. **تثبيت الاعتماديات:**
   ```bash
   composer install
   ```

3. **إعداد البيئة:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *قم بضبط إعدادات قاعدة البيانات في ملف .env*

4. **تهيئة قاعدة البيانات:**
   ```bash
   php artisan migrate --seed
   ```
   *(سيقوم هذا الأمر بإنشاء الجداول وإضافة بيانات تجريبية للمستشفيات، العيادات، والأطباء)*

5. **ربط التخزين:**
   ```bash
   php artisan storage:link
   ```

6. **تشغيل السيرفر:**
   ```bash
   php artisan serve
   ```

7. **تشغيل المجدول (للأتمتة):**
   ```bash
   php artisan schedule:work
   ```

---

## توثيق الـ API (Endpoints)

### 1. المصادقة (Auth)

#### تسجيل الدخول
```http
POST /api/login
Content-Type: application/json

{
    "email": "patient@example.com",
    "password": "password"
}
```

#### تسجيل حساب جديد
```http
POST /api/register
Content-Type: application/json

{
    "name": "New Patient",
    "email": "new@example.com",
    "password": "password",
    "phone": "0500000000"
}
```

---

### 2. بوابة المريض (Patient Portal)

#### استعراض الأطباء
```http
GET /api/doctors
```

#### معرفة الأوقات المتاحة لطبيب
```http
POST /api/doctors/{id}/slots
{
    "date": "2024-12-25"
}
```

#### حجز موعد
```http
POST /api/patient/appointments/book
Authorization: Bearer {token}

{
    "doctor_id": "uuid",
    "date": "2024-12-25",
    "time": "10:00"
}
```

#### تحميل روشتة طبية (PDF)
```http
GET /api/patient/medical-records/{record_id}/prescription
Authorization: Bearer {token}
```

---

### 3. بوابة الطبيب (Doctor Portal)

#### تحضير المريض (إثبات حضور)
```http
POST /api/doctor/appointments/{id}/attend
Authorization: Bearer {token}
```

#### إنشاء سجل طبي (تشخيص)
```http
POST /api/doctor/appointments/{id}/record
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "diagnosis": "Severe Flu",
    "prescription": "Panadol Extra",
    "files[]": [FILE_BINARY]
}
```

#### الاطلاع على تاريخ المريض
```http
GET /api/doctor/patient/{patient_id}/history
Authorization: Bearer {token}
```

---

### 4. الأتمتة (Automation & Cron Jobs)

يحتوي النظام على المهام المجدولة التالية:

1. **الروبوت الكناس (appointments:update-missed):**
   - يعمل كل ساعة.
   - يبحث عن المواعيد التي مر وقتها ولم يحضر المريض.
   - يحول حالتها تلقائياً إلى missed.

2. **منبه المواعيد (Daily Reminder):**
   - يعمل يومياً الساعة 9 صباحاً.
   - يرسل إشعارات للمرضى الذين لديهم مواعيد في اليوم التالي.

---

## الأمان والخصوصية

- **Private Storage:** جميع المرفقات الطبية تخزن في storage/app/private ولا يمكن الوصول إليها عبر رابط مباشر. يتم تحميلها فقط عبر Controller يتحقق من صلاحية المستخدم (Policy).
- **Rate Limiting:** حماية الـ API من الهجمات عبر تحديد عدد الطلبات المسموحة (Throttle).
- **Sanctum Tokens:** استخدام توكنات آمنة للتحقق من الهوية.

---

