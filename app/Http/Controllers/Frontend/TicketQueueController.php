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
            return redirect()->back()->with('error', 'Unauthorized access. You can only view your own tickets.');
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

        // Get priority ticket
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
            return redirect()->back()->with('error', 'Unauthorized access. You can only view your own tickets.');
        }

        // If user_id not specified, use logged in user's ID
        $patientId = $user_id ?: $user->id;
        
        $tickets = Ticket::with(['department', 'doctor'])
                    ->where('patient_id', $patientId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('frontend.tickets.list', compact('tickets'));
    }

    /**
     * Check status of a specific ticket via AJAX - Enhanced for real-time updates
     */
    public function checkStatus($id)
    {
        try {
            $ticket = Ticket::with(['department', 'doctor'])->findOrFail($id);

            // Authorization check
            if (Auth::guest() || 
                (Auth::user()->id !== $ticket->patient_id && 
                 Auth::user()->role_as !== 1)) {
                return response()->json([
                    'error' => 'Unauthorized. You can only check status of your own tickets.'
                ], 403);
            }

            // Calculate queue position for waiting tickets
            $queuePosition = null;
            $peopleAhead = 0;
            $estimatedWaitTime = 0;

            if ($ticket->status === 'waiting') {
                // Count tickets ahead in same department with lower position
                $peopleAhead = Ticket::where('department_id', $ticket->department_id)
                    ->where('status', 'waiting')
                    ->where('position', '<', $ticket->position)
                    ->count();

                // Calculate estimated wait time (assuming 15 minutes per patient)
                $estimatedWaitTime = $peopleAhead * 15;
                $queuePosition = $peopleAhead + 1;
            }

            // Get currently processing ticket for this department
            $currentlyProcessing = Ticket::with(['department', 'doctor'])
                ->where('department_id', $ticket->department_id)
                ->where('status', 'processing')
                ->first();

            return response()->json([
                'success' => true,
                'ticket' => [
                    'id' => $ticket->id,
                    'ticket_number' => $ticket->ticket_number,
                    'status' => $ticket->status,
                    'priority' => $ticket->priority,
                    'department' => $ticket->department->name,
                    'doctor' => $ticket->doctor->name,
                    'position' => $ticket->position,
                    'queue_position' => $queuePosition,
                    'people_ahead' => $peopleAhead,
                    'estimated_wait_time' => $estimatedWaitTime,
                    'created_at' => $ticket->created_at->toISOString(),
                    'updated_at' => $ticket->updated_at->toISOString()
                ],
                'currently_processing' => $currentlyProcessing ? [
                    'ticket_number' => $currentlyProcessing->ticket_number,
                    'department' => $currentlyProcessing->department->name,
                    'doctor' => $currentlyProcessing->doctor->name
                ] : null,
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch ticket status',
                'message' => $e->getMessage()
            ], 500);
        }
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