<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketQueueController extends Controller
{
    public function show($id)
    {
        // Get the requested ticket
        $ticket = Ticket::with(['department', 'doctor', 'patient'])->findOrFail($id);
        
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
    
    public function currentUser()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your tickets');
        }
        
        $tickets = Ticket::with(['department', 'doctor'])
                    ->where('patient_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('frontend.tickets.user-tickets', compact('tickets'));
    }
    
    public function displayQueue()
    {
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
            'regularTickets', 
            'priorityTickets', 
            'processingTickets'
        ));
    }
}