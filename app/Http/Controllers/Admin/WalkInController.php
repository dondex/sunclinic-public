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
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'birth_date' => 'nullable|date',
            'is_priority' => 'nullable|boolean',
            'priority_reason' => 'nullable|string|max:255',
        ]);

        // Check if user already exists by email or phone
        $user = null;
        if ($request->filled('email')) {
            $user = User::where('email', $request->input('email'))->first();
        }
        
        if (!$user && $request->filled('phone')) {
            $user = User::where('phone', $request->input('phone'))->first();
        }
        
        // If user doesn't exist, create a new one
        if (!$user) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->filled('email') ? $request->input('email') : null;
            $user->phone = $request->input('phone');
            $user->birth_date = $request->filled('birth_date') ? $request->input('birth_date') : null;
            $user->is_pwd = $request->boolean('is_priority');
            $user->password = bcrypt('password'); // Set a default password
            $user->role_as = '0'; // Regular user role
            $user->save();
        }

        // Generate a ticket for this walk-in
        $department = Department::find($request->input('department_id'));
        
        // Create a new ticket
        $ticket = new Ticket();
        $ticket->patient_id = $user->id;
        $ticket->department_id = $request->input('department_id');
        $ticket->doctor_id = $request->input('doctor_id');
        $ticket->status = 'waiting';
        $ticket->source = 'walk-in'; // Set source as walk-in
        
        // Set priority and generate ticket number
        if ($request->boolean('is_priority')) {
            $ticket->priority = 'priority';
            $ticket->ticket_number = $this->generatePriorityNumber();
        } else {
            $ticket->priority = 'regular';
            $ticket->ticket_number = $this->generateRegularNumber($department);
        }
        
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
    
    /**
     * Generate a priority ticket number (P-XXX format)
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