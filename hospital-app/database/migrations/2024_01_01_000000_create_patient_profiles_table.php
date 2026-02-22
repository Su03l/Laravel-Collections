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
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary(); // استخدام UUID
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade'); // ربط بـ UUID
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('blood_type')->nullable();
            $table->text('chronic_diseases')->nullable(); // أمراض مزمنة
            $table->text('allergies')->nullable(); // حساسية
            $table->text('past_surgeries')->nullable(); // عمليات سابقة
            $table->softDeletes(); // حذف ناعم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
