@extends('layouts.master')

@section('title', 'Add Record')

@section('content')

<div class="container-fluid">

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-0">

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
            <h4 class="mb-0">Add Record</h4>
            <a href="{{ url('admin/records') }}" class="btn btn-light btn-sm shadow-sm">
                <i class="fas fa-arrow-alt-circle-left text-primary mx-2"></i>Back
            </a>
        </div>
        
        <div class="card-body">
            <form action="{{ url('admin/add-record') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <h3 class="pb-3">PERSONAL INFORMATION</h3>
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label"><b>Patient Name</b></label>
                        <select name="user_id" class="form-select" required>
                            @foreach ($user as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3"> 
                        <label for="profile_image" class="form-label label-bottom"><b>Profile Picture</b></label>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                    </div>

                    <div class="col-md-6 mb-3">
                            <label for="resident_number" class="form-label "><b>Resident Number</b></label>
                           
                            <input type="text"  name="resident_number" class="form-control" required>
                          
                    </div>

                    <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label "><b>Phone Number</b></label>
                            <input type="text" name="phone_number" class="form-control"required >
                    </div>

                    <div class="col-md-6 mb-3">
                            <label for="birthday" class="form-label "><b>Birthday</b></label>
                            <input type="date" name="birthday" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label"><b>Gender</b></label>
                        <select name="gender" class="form-control" required>
                            <option value="">Select Gender</option> <!-- Default option -->
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label"><b>Address</b></label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <hr class="my-4">


                <div class="row">
                    <h3 class="pb-3">MEDICAL RECORDS</h3>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="lab_results_image" class="form-label label-bottom"><b>Upload Lab Results Image</b></label>
                            <span class="span-text">Results from blood tests, urine tests, etc.</span>
                        </div>
                        
                        <input type="file" name="lab_results_image" class="form-control" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .ppt, .pptx, .txt, .zip, .rar">
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="past_medical_history" class="form-label"><b>Past Medical History</b></label>
                            <span class="span-text">Records of previous illnesses, surgeries, and treatments.</span>
                        </div>

                        <textarea name="past_medical_history" class="form-control" rows="3" placeholder="Enter past medical history..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">

                        <div class="d-flex flex-column wrapper-label">
                            <label for="imaging_studies_image" class="form-label"><b>Upload Imaging Studies Image</b></label>
                             <span class="span-text">X-rays, MRIs, CT scans, and their results.</span>
                        </div>
                        <input type="file" name="imaging_studies_image" class="form-control" accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .ppt, .pptx, .txt, .zip, .rar">
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="family_medical_history" class="form-label"><b>Family Medical History</b></label>
                            <span class="span-text">Information about hereditary conditions in the family.</span>
                        </div>
                        <textarea name="family_medical_history" class="form-control" rows="3" placeholder="Enter family medical history..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="current_medications" class="form-label"><b>Current Medications</b></label>
                            <span class="span-text">List of medications the patient is currently taking.</span>
                        </div>
                        <textarea name="current_medications" class="form-control" rows="3" placeholder="Enter current medications..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="treatment_plans" class="form-label">Treatment Plans</label>
                            <span class="span-text">Details of ongoing treatments and therapies.</span>
                        </div>
                        <textarea name="treatment_plans" class="form-control" rows="3" placeholder="Enter treatment plans..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="lab_test_results" class="form-label"><b>Lab Test Results</b></label>
                            <span class="span-text">NOTE Results from blood tests, urine tests, etc.</span>
                        </div>
                        <textarea name="lab_test_results" class="form-control" rows="3" placeholder="Enter lab test results..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="physical_exam_notes" class="form-label"><b>Physical Exam Notes</b></label>
                            <span class="span-text">Findings from physical assessments.</span>
                        </div>
                        <textarea name="physical_exam_notes" class="form-control" rows="3" placeholder="Enter physical exam notes..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="appointment_history" class="form-label"><b>Appointment History</b></label>
                            <span class="span-text">Dates and details of past appointments.</span>
                        </div>
                        <textarea name="appointment_history" class="form-control" rows="3" placeholder="Enter appointment history..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="upcoming_appointments" class="form-label"><b>Upcoming Appointments</b></label>
                            <span class="span-text">Scheduled future appointments.</span>
                        </div>
                        <textarea name="upcoming_appointments" class="form-control" rows="3" placeholder="Enter upcoming appointments..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="appointment_feedback" class="form-label"><b>Appointment Feedback</b></label>
                            <span class="span-text">Patient feedback regarding their experience.</span>
                        </div>
                        <textarea name="appointment_feedback" class="form-control" rows="3" placeholder="Enter appointment feedback..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="prescription_history" class="form-label"><b>Prescription History</b></label>
                            <span class="span-text">Records of all prescriptions given to the patient.</span>
                        </div>
                        <textarea name="prescription_history" class="form-control" rows="3" placeholder="Enter prescription history..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="known_allergies" class="form-label"><b>Known Allergies</b></label>
                            <span class="span-text">List of allergies to medications or substances.</span>
                        </div>
                        <textarea name="known_allergies" class="form-control" rows="3" placeholder="Enter known allergies..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="adverse_reactions" class="form-label"><b>Adverse Reactions</b></label>
                            <span class="span-text">Records of any adverse reactions to treatments.</span>
                        </div>
                        <textarea name="adverse_reactions" class="form-control" rows="3" placeholder="Enter adverse reactions..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="vaccination_history" class="form-label"><b>Vaccination History</b></label>
                            <span class="span-text">List of vaccinations received, including dates and types.</span>
                        </div>
                        <textarea name="vaccination_history" class="form-control" rows="3" placeholder="Enter vaccination history..."></textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column wrapper-label">
                                <label for="lifestyle_factors" class="form-label"><b>Lifestyle Factors</b></label>
                                <span class="span-text">Information on smoking, alcohol use, diet, and exercise.</span>
                            </div>
                        <textarea name="lifestyle_factors" class="form-control" rows="3" placeholder="Enter lifestyle factors..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="social_determinants" class="form-label"><b>Social Determinants</b></label>
                            <span class="span-text">Factors that may impact health, such as living conditions and employment.</span>
                        </div>
                        <textarea name="social_determinants" class="form-control" rows="3" placeholder="Enter social determinants..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="communication_logs" class="form-label"><b>Communication Logs</b></label>
                            <span class="span-text">Records of messages and communications between the patient and healthcare providers.</span>
                        </div>
                        <textarea name="communication_logs" class="form-control" rows="3" placeholder="Enter communication logs..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="care_plans" class="form-label"><b>Care Plans</b></label>
                            <span class="span-text">Plans for ongoing care, including goals and follow-up appointments.</span>
                        </div>
                        <textarea name="care_plans" class="form-control" rows="3" placeholder="Enter care plans..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="patient_generated_data" class="form-label"><b>Patient Generated Data</b></label>
                            <span class="span-text">Symptom Tracking: Information entered by patients regarding their symptoms.</span>
                            <span class="span-text">Health Metrics: Data from wearable devices or health apps (e.g., blood pressure, glucose levels).</span>
                        </div>
                        <textarea name="patient_generated_data" class="form-control" rows="3" placeholder="Enter patient generated data..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="insurance_details" class="form-label"><b>Insurance Details</b></label>
                            <span class="span-text">Information about the patient's insurance provider and coverage.</span>
                        </div>
                        <textarea name="insurance_details" class="form-control" rows="3" placeholder="Enter insurance details..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column wrapper-label">
                            <label for="billing_history" class="form-label"><b>Billing History</b></label>
                            <span class="span-text">Records of billing and payment history.</span>
                        </div>
                        <textarea name="billing_history" class="form-control" rows="3" placeholder="Enter billing history..."></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection