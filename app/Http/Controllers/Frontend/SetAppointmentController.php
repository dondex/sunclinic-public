<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Ticket;
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

        // Check if user already has an active ticket
        $activeTicket = Ticket::where('patient_id', $user->id)
                         ->whereIn('status', ['waiting', 'processing'])
                         ->first();
                         
        if ($activeTicket) {
            // Directly redirect to ticket view page instead of showing the form with a button
            return redirect()->route('ticket.show', $activeTicket->id)
                   ->with('message', 'You already have an active ticket. Your ticket number is ' . $activeTicket->ticket_number);
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
        
        // Check if user already has an active ticket
        $userId = $request->input('user_id');
        $activeTicket = Ticket::where('patient_id', $userId)
                         ->whereIn('status', ['waiting', 'processing'])
                         ->first();
                         
        if ($activeTicket) {
            // Directly redirect to ticket view page instead of showing feedback first
            return redirect()->route('ticket.show', $activeTicket->id)
                   ->with('message', 'You already have an active ticket. Your ticket number is ' . $activeTicket->ticket_number);
        }

        // Create a new appointment instance
        $appointment = new Appointment();
        $appointment->user_id = $userId;
        $appointment->department_id = $request->input('department_id');
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->subject = $request->input('subject');
        $appointment->appointment_date_time = $request->input('appointment_date_time');
        $appointment->appointment_time = $request->input('appointment_time');

        // Save the appointment to the database
        $appointment->save();

        // Generate a ticket for this appointment
        $ticket = $this->generateTicket($appointment);

        // Redirect to the ticket view page
        return redirect()->route('ticket.show', $ticket->id)->with('message', 'Appointment scheduled successfully. Your ticket number is ' . $ticket->ticket_number);
    }

    /**
     * Generate a ticket for an appointment
     * 
     * @param Appointment $appointment
     * @return Ticket
     */
    private function generateTicket(Appointment $appointment)
    {
        $isPriority = $this->checkIfPriorityPatient($appointment->user_id);
        $department = Department::find($appointment->department_id);
        
        // Create a new ticket
        $ticket = new Ticket();
        $ticket->patient_id = $appointment->user_id;
        $ticket->department_id = $appointment->department_id;
        $ticket->doctor_id = $appointment->doctor_id;
        $ticket->status = 'waiting';
        $ticket->source = 'appointment';
        
        // Set priority and generate ticket number
        if ($isPriority) {
            $ticket->priority = 'priority';
            $ticket->ticket_number = $this->generatePriorityNumber();
        } else {
            $ticket->priority = 'regular';
            $ticket->ticket_number = $this->generateRegularNumber($department);
        }
        
        $ticket->save();
        
        return $ticket;
    }
    
    /**
     * Generate a priority ticket number (P-XXX format)
     * 
     * @return string
     */
    private function generatePriorityNumber()
    {
        $latestTicket = Ticket::where('priority', 'priority')
            ->orderBy('id', 'desc')
            ->first();
            
        $number = $latestTicket ? intval(substr($latestTicket->ticket_number, 2)) + 1 : 1;
        return 'P-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    /**
     * Generate a regular ticket number (XX-XXX format)
     * 
     * @param Department $department
     * @return string
     */
    private function generateRegularNumber(Department $department)
    {
        $prefix = $this->getDepartmentPrefix($department);
        
        $latestTicket = Ticket::where('priority', 'regular')
            ->where('ticket_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();
            
        $number = $latestTicket ? intval(substr($latestTicket->ticket_number, 3)) + 1 : 1;
        return $prefix . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get the prefix for a department's tickets
     * 
     * @param Department $department
     * @return string
     */
    private function getDepartmentPrefix(Department $department)
    {
        // If department has a code attribute, use that
        if (!empty($department->code)) {
            return strtoupper(substr($department->code, 0, 1));
        }
        
        // If department has a name attribute, use the first letter
        if (!empty($department->name)) {
            return strtoupper(substr($department->name, 0, 1));
        }
        
        // Default prefix if no name or code is available
        return 'T';
    }

    /**
     * Check if the patient should be given priority status
     * 
     * @param int $user_id
     * @return bool
     */
    private function checkIfPriorityPatient($user_id)
    {
        $user = User::find($user_id);
        
        // Check for age > 60 (senior)
        if ($user && isset($user->birth_date)) {
            $birthDate = new \DateTime($user->birth_date);
            $today = new \DateTime();
            $age = $birthDate->diff($today)->y;
            
            if ($age >= 60) {
                return true;
            }
        }
        
        // Check for PWD or other priority status flag
        if ($user && isset($user->is_pwd) && $user->is_pwd) {
            return true;
        }
        
        // Check if pregnant
        if ($user && isset($user->is_pregnant) && $user->is_pregnant) {
            return true;
        }
        
        return false; // Default to regular priority
    }
}