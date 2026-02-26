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
        Schema::create('medical_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade'); // Who accessed
            $table->foreignUuid('medical_record_id')->constrained()->onDelete('cascade'); // Which record
            $table->string('action')->default('view'); // view, download_pdf, view_history
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable(); // Device/Browser info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_access_logs');
    }
};
