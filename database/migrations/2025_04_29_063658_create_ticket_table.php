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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 10)->unique();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('doctor_id')->constrained();
            $table->foreignId('patient_id')->nullable()->constrained('users');
            $table->enum('priority', ['regular', 'priority'])->default('regular');
            $table->enum('status', ['waiting', 'processing', 'completed'])->default('waiting');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
