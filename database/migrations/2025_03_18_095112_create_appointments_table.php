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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key to Users Table
            $table->foreignId('department_id')->constrained()->onDelete('cascade'); // Foreign Key to Departments Table
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade'); // Foreign Key to Doctors Table
            $table->dateTime('appointment_date_time'); // Datetime for appointment
            $table->string('subject'); 
            $table->enum('status', ['Pending', 'Accepted', 'Declined'])->default('Pending'); // Status field
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
