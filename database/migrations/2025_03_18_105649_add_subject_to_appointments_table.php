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
        Schema::table('appointments', function (Blueprint $table) {
            // Check if the column does not exist before adding it
            if (!Schema::hasColumn('appointments', 'subject')) {
                $table->string('subject')->after('appointment_date_time'); // Add subject field
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('subject'); // Remove subject field if rolling back
        });
    }
};
