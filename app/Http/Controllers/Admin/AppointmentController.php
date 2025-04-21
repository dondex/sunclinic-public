<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('admin.appointment.index', compact('appointments'));
    }

    public function create()
    {
        
        $user = User::where('role_as', '0')->get();
        $departments = Department::all();

        return view('admin.appointment.create', compact('departments', 'user'));
    }

    public function getDoctorsByDepartment(Request $request)
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
        return redirect('admin/appointments')->with('message', 'Appointment Added Successfully');
    }

    public function edit($appointment_id)
        {
            // Find the appointment by ID
            $appointment = Appointment::findOrFail($appointment_id);

            // Fetch all users and departments
            $users = User::all();
            $departments = Department::all();

            // Fetch doctors based on the department of the current appointment
            $doctors = Doctor::where('department_id', $appointment->department_id)->get();

            return view('admin.appointment.edit', compact('appointment', 'users', 'departments', 'doctors'));
        }

        public function update(Request $request, $appointment_id)
        {
            // Validate the incoming request data
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'department_id' => 'required|exists:departments,id',
                'doctor_id' => 'required|exists:doctors,id',
                'subject' => 'required|string|max:255',
                'appointment_date_time' => 'required|date',
                'appointment_time' => 'required|string|max:10',
                'status' => 'required|in:Pending,Accepted,Declined', // Validate status
            ]);
        
            // Find the appointment by ID
            $appointment = Appointment::findOrFail($appointment_id);
        
            // Update the appointment instance with the new data
            $appointment->user_id = $request->input('user_id');
            $appointment->department_id = $request->input('department_id');
            $appointment->doctor_id = $request->input('doctor_id');
            $appointment->subject = $request->input('subject');
            $appointment->appointment_date_time = $request->input('appointment_date_time');
            $appointment->appointment_time = $request->input('appointment_time');
            $appointment->status = $request->input('status'); // Update status
        
            // Save the updated appointment to the database
            $appointment->save();
        
            // Redirect to a specific route with a success message
            return redirect('admin/appointments')->with('message', 'Appointment Updated Successfully');
        }


    
}
