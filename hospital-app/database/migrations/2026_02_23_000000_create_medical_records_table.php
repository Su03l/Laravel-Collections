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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('appointment_id')->constrained()->unique(); // One record per appointment
            $table->foreignUuid('patient_id')->constrained('users');
            $table->foreignUuid('doctor_id')->constrained('doctors');
            $table->text('diagnosis');      // Diagnosis
            $table->text('prescription');   // Prescription
            $table->text('doctor_notes')->nullable(); // Private notes for the doctor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
