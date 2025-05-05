<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketQueueController extends Controller
{
    /**
     * Show a specific ticket
     */
    public function show($id)
    {
        // Get the requested ticket
        $ticket = Ticket::with(['department', 'doctor', 'patient'])->findOrFail($id);

        // Check if user owns this ticket or is admin/staff
        if (Auth::user()->id != $ticket->patient_id && Auth::user()->role_as != '1') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Get tickets ahead in the queue (same department, same priority, created earlier)
        $waitingTickets = Ticket::where('department_id', $ticket->department_id)
                        ->where('priority', $ticket->priority)
                        ->where('status', 'waiting')
                        ->where('created_at', '<', $ticket->created_at)
                        ->count();

        // Get recent tickets for display
        $recentRegularTickets = Ticket::with(['department', 'doctor'])
                        ->where('status', 'waiting')
                        ->where('priority', 'regular')
                        ->orderBy('created_at', 'asc')
                        ->take(3)
                        ->get();

        // Get priority tickets
        $priorityTicket = Ticket::with(['department', 'doctor'])
                        ->where('status', 'waiting')
                        ->where('priority', 'priority')
                        ->orderBy('created_at', 'asc')
                        ->first();

        return view('frontend.tickets.show', compact(
            'ticket',
            'waitingTickets',
            'recentRegularTickets',
            'priorityTicket'
        ));
    }

    /**
     * List all tickets for the current user
     */
    public function currentUser($user_id = null)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your tickets');
        }

        // Verify user is accessing their own tickets
        if ($user_id && $user->id != $user_id && $user->role_as != '1') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $tickets = Ticket::with(['department', 'doctor'])
                    ->where('patient_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('frontend.tickets.list', compact('tickets'));
    }

    /**
     * Check status of a specific ticket via AJAX
     */
   public function checkStatus($id)
{
    $ticket = Ticket::with(['department', 'doctor'])
        ->where('id', $id)
        ->first();

    if (!$ticket) {
        return response()->json(['error' => 'Ticket not found'], 404);
    }

    // Authorization check
    if (Auth::guest() || 
        (Auth::user()->id !== $ticket->patient_id && 
         Auth::user()->role_as !== 1)) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    return response()->json([
        'status' => $ticket->status,
        'department' => $ticket->department->name,
        'doctor' => $ticket->doctor->name,
        'updated_at' => $ticket->updated_at->toISOString()
    ]);
}

    /**
     * Display the public queue
     */
    public function displayQueue()
    {
        $currentTicket = Ticket::where('status', 'processing')->first();
        $waitingTickets = Ticket::where('status', 'waiting')
            ->orderBy('position')
            ->take(5)
            ->get();

        $regularTickets = Ticket::with(['department', 'doctor'])
                        ->where('status', 'waiting')
                        ->where('priority', 'regular')
                        ->orderBy('created_at', 'asc')
                        ->take(5)
                        ->get();

        $priorityTickets = Ticket::with(['department', 'doctor'])
                        ->where('status', 'waiting')
                        ->where('priority', 'priority')
                        ->orderBy('created_at', 'asc')
                        ->take(3)
                        ->get();

        $processingTickets = Ticket::with(['department', 'doctor'])
                        ->where('status', 'processing')
                        ->orderBy('updated_at', 'desc')
                        ->take(5)
                        ->get();

        return view('frontend.tickets.queue-display', compact(
            'currentTicket',
            'waitingTickets',
            'regularTickets',
            'priorityTickets',
            'processingTickets'
        ));
    }
}