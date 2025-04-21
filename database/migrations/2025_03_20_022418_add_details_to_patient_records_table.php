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
        Schema::table('patient_records', function (Blueprint $table) {
            $table->string('resident_number'); // Add Resident Number (required)
            $table->string('phone_number'); // Add Phone Number (required)
            $table->date('birthday'); // Add Birthday (required)
            $table->enum('gender', ['male', 'female']); // Add Gender (required)
            $table->text('address'); // Add Address (required)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_records', function (Blueprint $table) {
            $table->dropColumn('resident_number'); // Remove Resident Number
            $table->dropColumn('phone_number'); // Remove Phone Number
            $table->dropColumn('birthday'); // Remove Birthday
            $table->dropColumn('gender'); // Remove Gender
            $table->dropColumn('address'); // Remove Address
        });
    }
};
