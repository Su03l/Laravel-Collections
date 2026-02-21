<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('habit_id')->constrained('habits')->cascadeOnDelete();
            $table->date('completed_date'); // التاريخ المستهدف
            $table->boolean('completed')->default(false);
            $table->timestamps();

            // تأمين البيانات: لا يمكن تكرار تسجيل العادة لنفس اليوم
            $table->unique(['habit_id', 'completed_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};
