<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('appointment_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignUuid('patient_id')->constrained('users');
            $table->foreignUuid('doctor_id')->constrained('doctors');
            $table->integer('rating')->unsigned(); // 1 to 5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
