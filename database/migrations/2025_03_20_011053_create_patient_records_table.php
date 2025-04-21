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
        Schema::create('patient_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users table
            $table->text('past_medical_history')->nullable();
            $table->text('family_medical_history')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('treatment_plans')->nullable();
            $table->text('lab_test_results')->nullable(); // This can store descriptions or notes
            $table->string('lab_results_image')->nullable(); // Path for uploaded lab results image
            $table->string('imaging_studies_image')->nullable(); // Path for uploaded imaging studies image
            $table->text('physical_exam_notes')->nullable();
            $table->text('appointment_history')->nullable();
            $table->text('upcoming_appointments')->nullable();
            $table->text('appointment_feedback')->nullable();
            $table->text('prescription_history')->nullable();
            $table->text('known_allergies')->nullable();
            $table->text('adverse_reactions')->nullable();
            $table->text('vaccination_history')->nullable();
            $table->text('lifestyle_factors')->nullable();
            $table->text('social_determinants')->nullable();
            $table->text('communication_logs')->nullable();
            $table->text('care_plans')->nullable();
            $table->text('patient_generated_data')->nullable();
            $table->text('insurance_details')->nullable();
            $table->text('billing_history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_records');
    }
};
