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
        Schema::create('medical_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('patient_id')->constrained('users');
            $table->foreignUuid('doctor_id')->constrained('doctors');
            $table->timestamp('consented_at'); // Time of consent
            $table->string('ip_address')->nullable(); // To document location/identity
            $table->boolean('is_active')->default(true); // To allow revocation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_consents');
    }
};
