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
        // This file is intentionally left empty to avoid conflict with 0000_00_00_000000_create_departments_table.php
        // which was created to ensure the departments table exists before the users table.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
