<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;

class WalkInController extends Controller
{
    /**
     * Display the form for creating a new walk-in appointment
     */
    public function create()
    {
        // Get all departments for dropdown
        $departments = Department::all();
        
        return view('admin.walkin.create', compact('departments'));
    }

    /**
     * Get doctors by department (AJAX request)
     */
    public function doctorsByDepartment(Request $request)
    {
        $departmentId = $request->input('department_id');
        $doctors = Doctor::where('department_id', $departmentId)->get();

        return response()->json($doctors);
    }

    /**
     * Store a new walk-in appointment and generate ticket
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'resident_number' => 'required|string|max:255', // Add validation for resident_number
        ]);

        // Create a new user for the walk-in
        $user = new User();
        $user->name = $request->input('name');
        // Generate a placeholder email
        $user->email = 'walkin_' . time() . '@placeholder.com';
        // Set resident_number from request
        $user->resident_number = $request->input('resident_number');
        $user->password = bcrypt('password'); // Set a default password
        $user->role_as = '0'; // Regular user role
        $user->save();

        // Generate a ticket for this walk-in
        $department = Department::find($request->input('department_id'));
        
        // Create a new ticket
        $ticket = new Ticket();
        $ticket->patient_id = $user->id;
        $ticket->department_id = $request->input('department_id');
        $ticket->doctor_id = $request->input('doctor_id');
        $ticket->status = 'waiting';
        $ticket->source = 'walk-in'; // Set source as walk-in
        
        // All walk-ins are regular priority now
        $ticket->priority = 'regular';
        $ticket->ticket_number = $this->generateRegularNumber($department);
        
        $ticket->save();
        
        return redirect()->route('admin.walkin.ticket', $ticket->id)
            ->with('message', 'Walk-in patient registered successfully. Ticket number: ' . $ticket->ticket_number);
    }
    
    /**
     * Display the ticket for a walk-in appointment
     */
    public function showTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $priorityTicket = null;
        
        return view('admin.walkin.ticket', compact('ticket', 'priorityTicket'));
    }
    
    // This method is kept for compatibility with other controllers
    private function generatePriorityNumber()
    {
        $latestTicket = Ticket::where('priority', 'priority')
            ->orderBy('id', 'desc')
            ->first();
            
        $number = $latestTicket ? intval(substr($latestTicket->ticket_number, 2)) + 1 : 1;
        return 'P-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    /**
     * Generate a regular ticket number (X-XXX format)
     */
    private function generateRegularNumber(Department $department)
    {
        $prefix = $this->getDepartmentPrefix($department);
        
        $latestTicket = Ticket::where('priority', 'regular')
            ->where('ticket_number', 'like', $prefix . '-%')
            ->orderBy('id', 'desc')
            ->first();
        
        if ($latestTicket) {
            // Extract only the numeric part after the dash
            $parts = explode('-', $latestTicket->ticket_number);
            $number = isset($parts[1]) ? intval($parts[1]) + 1 : 1;
        } else {
            $number = 1;
        }
        
        // Format as X-001
        return $prefix . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get the prefix for a department's tickets
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
}