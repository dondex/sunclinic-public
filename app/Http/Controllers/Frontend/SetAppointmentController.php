<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetAppointmentController extends Controller
{
    public function create()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has the role you want (e.g., role_as = '0')
        if (!$user || $user->role_as != '0') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Get all departments
        $departments = Department::all();

        return view('frontend.appointment.create', compact('departments', 'user'));
    }

    public function doctorsByDepartment(Request $request)
    {
        $departmentId = $request->input('department_id');
        $doctors = Doctor::where('department_id', $departmentId)->get();

        return response()->json($doctors);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'subject' => 'required|string|max:255',
            'appointment_date_time' => 'required|date',
            'appointment_time' => 'required|string|max:10',
        ]);

        // Create a new appointment instance
        $appointment = new Appointment();
        $appointment->user_id = $request->input('user_id');
        $appointment->department_id = $request->input('department_id');
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->subject = $request->input('subject');
        $appointment->appointment_date_time = $request->input('appointment_date_time');
        $appointment->appointment_time = $request->input('appointment_time');

        // Save the appointment to the database
        $appointment->save();

        // Redirect to a specific route with a success message
        return redirect('set-appointment/{user_id}')->with('message', 'Appointment Added Successfully');
    }
}
