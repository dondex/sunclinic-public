@extends('layouts.app-nonav')

@section('title', 'Obeid Hospital')

@section('content')

<div class="container-fluid bg-blue p-1">
    <div class="row mx-2">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ url('/') }}" class="btn btn-primary btn-sm shadow-sm my-3">
                    <i class="fas fa-chevron-left text-white p-2"></i>
                </a>
            </div>
            <div class="text-center">
                <h5 class="text-white">Medical Records</h5>
            </div>
        </div>
    </div>
    <div class="row mx-2 pt-3">
        <h5 class="font-bold text-capitalize text-white">{{ $user->name }}'s Record</h5>
    </div>

    @foreach($records as $record)
        @if(!empty($record->past_medical_history))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Past Medical History</h6>
                    <p>{{ $record->past_medical_history }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->family_medical_history))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Family Medical History</h6>
                    <p>{{ $record->family_medical_history }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->current_medications))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Current Medications</h6>
                    <p>{{ $record->current_medications }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->treatment_plans))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Treatment Plans</h6>
                    <p>{{ $record->treatment_plans }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->lab_test_results))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Lab Test Results</h6>
                    <p>{{ $record->lab_test_results }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->physical_exam_notes))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Physical Exam Notes</h6>
                    <p>{{ $record->physical_exam_notes }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->appointment_history))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Appointment History</h6>
                    <p>{{ $record->appointment_history }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->upcoming_appointments))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Upcoming Appointments</h6>
                    <p>{{ $record->upcoming_appointments }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->appointment_feedback))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Appointment Feedback</h6>
                    <p>{{ $record->appointment_feedback }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->prescription_history))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Prescription History</h6>
                    <p>{{ $record->prescription_history }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->known_allergies))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Known Allergies</h6>
                    <p>{{ $record->known_allergies }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->adverse_reactions))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Adverse Reactions</h6>
                    <p>{{ $record->adverse_reactions }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->vaccination_history))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Vaccination History</h6>
                    <p>{{ $record->vaccination_history }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->lifestyle_factors))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Lifestyle Factors</h6>
                    <p>{{ $record->lifestyle_factors }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->social_determinants))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Social Determinants</h6>
                    <p>{{ $record->social_determinants }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->communication_logs))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Communication Logs</h6>
                    <p>{{ $record->communication_logs }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->care_plans))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Care Plans</h6>
                    <p>{{ $record->care_plans }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->patient_generated_data))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Patient Generated Data</h6>
                    <p>{{ $record->patient_generated_data }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->insurance_details))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Insurance Details</h6>
                    <p>{{ $record->insurance_details }}</p>
                </div>
            </div>
        @endif

        @if(!empty($record->billing_history))
            <div class="row m-3 bg-white px-1 py-4 rounded">
                <div class="rounded shadow-sm p-3">
                    <h6>Billing History</h6>
                    <p>{{ $record->billing_history }}</p>
                </div>
            </div>
        @endif

        

       

    @endforeach

</div>
@endsection