<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // هذا السطر السحري بينشئ حقلين: likeable_id و likeable_type
            // عشان نعرف هل اللايك لمقال ولا لتعليق
            $table->morphs('likeable');

            $table->timestamps();

            // منع اليوزر يعطي لايكين لنفس الشيء
            $table->unique(['user_id', 'likeable_id', 'likeable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
