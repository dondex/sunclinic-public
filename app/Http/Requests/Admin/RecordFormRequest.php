<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RecordFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'user_id' => 'required|exists:users,id', 
            'resident_number' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15', 
            'birthday' => 'required|date',
            'gender' => 'required|in:male,female', 
            'address' => 'nullable|string|max:500', 
            'lab_results_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx,ppt,pptx,txt,zip,rar|max:5120', // 5 MB
            'past_medical_history' => 'nullable|string|max:1000',
            'imaging_studies_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx,ppt,pptx,txt,zip,rar|max:5120', // 5 MB
            'family_medical_history' => 'nullable|string|max:1000',
            'current_medications' => 'nullable|string|max:1000',
            'treatment_plans' => 'nullable|string|max:1000',
            'lab_test_results' => 'nullable|string|max:1000',
            'physical_exam_notes' => 'nullable|string|max:1000',
            'appointment_history' => 'nullable|string|max:1000',
            'upcoming_appointments' => 'nullable|string|max:1000',
            'appointment_feedback' => 'nullable|string|max:1000',
            'prescription_history' => 'nullable|string|max:1000',
            'known_allergies' => 'nullable|string|max:1000',
            'adverse_reactions' => 'nullable|string|max:1000',
            'vaccination_history' => 'nullable|string|max:1000',
            'lifestyle_factors' => 'nullable|string|max:1000',
            'social_determinants' => 'nullable|string|max:1000',
            'communication_logs' => 'nullable|string|max:1000',
            'care_plans' => 'nullable|string|max:1000',
            'patient_generated_data' => 'nullable|string|max:1000',
            'insurance_details' => 'nullable|string|max:1000',
            'billing_history' => 'nullable|string|max:1000',
        ];

        return $rules;
    }
}
