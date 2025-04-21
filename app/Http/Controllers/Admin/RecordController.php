<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecordFormRequest;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        $record = Record::all();
        $user = User::where('role_as', '0')->get();
        return view('admin.record.index', compact('record', 'user'));
    }

    public function create()
    {
        $user = User::where('role_as', '0')->get();
        return view('admin.record.create', compact('user'));
    }

    public function store(RecordFormRequest $request)
    {
        // Validate the incoming request data
        $data = $request->validated();

        // Create a new Record instance
        $record = new Record;

        // Assign the validated data to the record
        $record->user_id = $data['user_id'];
        $record->profile_image = $data['profile_image'] ?? null; // Use null if not set
        $record->resident_number = $data['resident_number'];
        $record->phone_number = $data['phone_number'];
        $record->birthday = $data['birthday'];
        $record->gender = $data['gender'];
        $record->address = $data['address'];
        $record->past_medical_history = $data['past_medical_history'];
        $record->family_medical_history = $data['family_medical_history'];
        $record->current_medications = $data['current_medications'];
        $record->treatment_plans = $data['treatment_plans'];
        $record->lab_test_results = $data['lab_test_results'];
        // $record->imaging_studies_image = $data['imaging_studies_image'];
        $record->physical_exam_notes = $data['physical_exam_notes'];
        $record->appointment_history = $data['appointment_history'];
        $record->upcoming_appointments = $data['upcoming_appointments'];
        $record->appointment_feedback = $data['appointment_feedback'];
        $record->prescription_history = $data['prescription_history'];
        $record->known_allergies = $data['known_allergies'];
        $record->adverse_reactions = $data['adverse_reactions'];
        $record->vaccination_history = $data['vaccination_history'];
        $record->lifestyle_factors = $data['lifestyle_factors'];
        $record->social_determinants = $data['social_determinants'];
        $record->communication_logs = $data['communication_logs'];
        $record->care_plans = $data['care_plans'];
        $record->patient_generated_data = $data['patient_generated_data'];
        $record->insurance_details = $data['insurance_details'];
        $record->billing_history = $data['billing_history'];
    
        
        // Handle file uploads
        if ($request->hasFile('profile_image')) {
            $profilePicture = $request->file('profile_image');
            $filename = time() . '_profile.' . $profilePicture->getClientOriginalExtension(); // Generate a unique filename
            $profilePicture->move(public_path('uploads/profile_pictures'), $filename); // Move the file to the specified directory
            $record->profile_image = 'uploads/profile_pictures/' . $filename; // Store the relative path in the database
        }
        
        if ($request->hasFile('lab_results_image')) {
            $labResultsImage = $request->file('lab_results_image');
            $filename = time() . '_lab_results.' . $labResultsImage->getClientOriginalExtension(); // Generate a unique filename
            $labResultsImage->move(public_path('uploads/lab_results'), $filename); // Move the file to the specified directory
            $record->lab_results_image = 'uploads/lab_results/' . $filename; // Store the relative path in the database
        }

        if ($request->hasFile('imaging_studies_image')) {
            $imagingStudiesImage = $request->file('imaging_studies_image');
            $filename = time() . '_imaging_studies.' . $imagingStudiesImage->getClientOriginalExtension(); // Generate a unique filename
            $imagingStudiesImage->move(public_path('uploads/imaging_studies'), $filename); // Move the file to the specified directory
            $record->imaging_studies_image = 'uploads/imaging_studies/' . $filename; // Store the relative path in the database
        }
    
        // Save the record to the database
        $record->save();
    
        // Redirect back with a success message
        return redirect('admin/records')->with('message', 'Record Created Successfully!');
    }

    public function view($record_id)
    {
        // Fetch the record by ID
        $record = Record::findOrFail($record_id);

        // Return the view with the record data
        return view('admin.record.view-record', compact('record'));
    }


    public function edit($record_id)
    {
        // Fetch the record by ID
        $record = Record::findOrFail($record_id);
        $user = User::where('role_as', '0')->get(); // Fetch users for the dropdown

        // Return the edit view with the record data
        return view('admin.record.edit', compact('record', 'user'));
    }

    public function update(RecordFormRequest $request, $record_id)
    {
        // Validate the incoming request data
        $data = $request->validated();

        // Find the record by ID
        $record = Record::findOrFail($record_id);

        // Assign the validated data to the record
        $record->user_id = $data['user_id'];
        $record->resident_number = $data['resident_number'];
        $record->phone_number = $data['phone_number'];
        $record->birthday = $data['birthday'];
        $record->gender = $data['gender'];
        $record->address = $data['address'];
        $record->past_medical_history = $data['past_medical_history'];
        $record->family_medical_history = $data['family_medical_history'];
        $record->current_medications = $data['current_medications'];
        $record->treatment_plans = $data['treatment_plans'];
        $record->lab_test_results = $data['lab_test_results'];
        // $record->imaging_studies_image = $data['imaging_studies_image'];
        $record->physical_exam_notes = $data['physical_exam_notes'];
        $record->appointment_history = $data['appointment_history'];
        $record->upcoming_appointments = $data['upcoming_appointments'];
        $record->appointment_feedback = $data['appointment_feedback'];
        $record->prescription_history = $data['prescription_history'];
        $record->known_allergies = $data['known_allergies'];
        $record->adverse_reactions = $data['adverse_reactions'];
        $record->vaccination_history = $data['vaccination_history'];
        $record->lifestyle_factors = $data['lifestyle_factors'];
        $record->social_determinants = $data['social_determinants'];
        $record->communication_logs = $data['communication_logs'];
        $record->care_plans = $data['care_plans'];
        $record->patient_generated_data = $data['patient_generated_data'];
        $record->insurance_details = $data['insurance_details'];
        $record->billing_history = $data['billing_history'];

        // Handle file uploads (if any)
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($record->profile_image) {
                unlink(public_path($record->profile_image));
            }
            $profilePicture = $request->file('profile_image');
            $filename = time() . '_profile.' . $profilePicture->getClientOriginalExtension();
            $profilePicture->move(public_path('uploads/profile_pictures'), $filename);
            $record->profile_image = 'uploads/profile_pictures/' . $filename;
        }

        if ($request->hasFile('lab_results_image')) {
            // Delete the old lab results image if it exists
            if ($record->lab_results_image) {
                unlink(public_path($record->lab_results_image));
            }
            $labResultsImage = $request->file('lab_results_image');
            $filename = time() . '_lab_results.' . $labResultsImage->getClientOriginalExtension();
            $labResultsImage->move(public_path('uploads/lab_results'), $filename);
            $record->lab_results_image = 'uploads/lab_results/' . $filename;
        }

        if ($request->hasFile('imaging_studies_image')) {
            // Delete the old imaging studies image if it exists
            if ($record->imaging_studies_image) {
                unlink(public_path($record->imaging_studies_image));
            }
            $imagingStudiesImage = $request->file('imaging_studies_image');
            $filename = time() . '_imaging_studies.' . $imagingStudiesImage->getClientOriginalExtension();
            $imagingStudiesImage->move(public_path('uploads/imaging_studies'), $filename);
            $record->imaging_studies_image = 'uploads/imaging_studies/' . $filename;
        }

        // Save the updated record to the database
        $record->save();

        // Redirect back with a success message
        return redirect('admin/records')->with('message', 'Record Updated Successfully!');
    }

    public function destroy($record_id)
    {
        $record = Record::find($record_id);
        $record->delete();

        return redirect('admin/records')->with('message', 'Record Deleted Successfully');
    }
}
