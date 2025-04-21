<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'patient_records';

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'past_medical_history',
        'family_medical_history',
        'current_medications',
        'treatment_plans',
        'lab_test_results',
        'lab_results_image',
        'imaging_studies_image',
        'physical_exam_notes',
        'appointment_history',
        'upcoming_appointments',
        'appointment_feedback',
        'prescription_history',
        'known_allergies',
        'adverse_reactions',
        'vaccination_history',
        'lifestyle_factors',
        'social_determinants',
        'communication_logs',
        'care_plans',
        'patient_generated_data',
        'insurance_details',
        'billing_history',
        'resident_number', 
        'phone_number',    
        'birthday',       
        'gender',          
        'address',
        'profile_image'   
    ];

    // Define the relationship with the User model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}