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
        Schema::table('medical_attachments', function (Blueprint $table) {
            $table->string('category')->default('General'); // (X-Ray, Lab-Result, Prescription, Report)
            $table->string('description')->nullable();      // Short description
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_attachments', function (Blueprint $table) {
            $table->dropColumn(['category', 'description']);
        });
    }
};
