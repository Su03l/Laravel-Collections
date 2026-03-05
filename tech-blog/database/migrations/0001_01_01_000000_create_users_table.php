<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // البيانات الأساسية
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // الصلاحيات والحالة
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->boolean('is_active')->default(true); // للتحكم بحظر المستخدمين

            // البروفايل (Profile)
            $table->string('avatar')->nullable(); // الصورة الشخصية
            $table->string('header_image')->nullable(); // الغلاف (Header)
            $table->text('bio')->nullable(); // النبذة
            $table->date('date_of_birth')->nullable();
            $table->string('country')->nullable();

            // الروابط (Socials)
            $table->string('website_url')->nullable();
            $table->string('github_url')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        // جداول إعادة تعيين كلمة المرور والجلسات (تأتي افتراضياً مع لارافيل)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
