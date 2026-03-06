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
        Schema::create('snippets', function (Blueprint $table) {
            $table->id();
            // ربط الكود بالقسم (علاقة One-to-Many)
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title'); // عنوان الكود
            $table->longText('code'); // الكود البرمجي نفسه
            $table->text('description')->nullable(); // وصف قصير للكود
            $table->string('language'); // اللغة البرمجية (بتفيدنا عشان نسوي Syntax Highlighting)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snippets');
    }
};
