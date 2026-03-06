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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم القسم (مثل: Laravel, React, CSS)
            $table->string('slug')->unique(); // الرابط الصديق لمحركات البحث
            $table->string('color')->default('#00ffcc'); // لون النيون اللي بنستخدمه في الفرونت إند
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
