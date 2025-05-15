<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    /**
     * Display monitor dashboard
     */
    public function index()
    {
        return view('monitor.dashboard');
    }

    /**
     * Get current processing ticket (API endpoint)
     */
    public function currentTicket()
    {
        // Get current priority ticket
        $priorityTicket = Ticket::with(['department', 'doctor'])
            ->where('status', 'processing')
            ->where('is_priority', true)
            ->first();
            
        // Get current regular ticket
        $regularTicket = Ticket::with(['department', 'doctor'])
            ->where('status', 'processing')
            ->where('is_priority', false)
            ->first();
            
        // Count waiting tickets in both queues
        $priorityWaitingCount = Ticket::where('status', 'waiting')
            ->where('is_priority', true)
            ->count();
            
        $regularWaitingCount = Ticket::where('status', 'waiting')
            ->where('is_priority', false)
            ->count();

        return response()->json([
            // Priority queue data
            'priority_ticket_number' => $priorityTicket->ticket_number ?? null,
            'priority_department' => $priorityTicket->department->name ?? 'N/A',
            'priority_doctor' => $priorityTicket->doctor->name ?? 'N/A',
            'priority_waiting_count' => $priorityWaitingCount,
            
            // Regular queue data
            'regular_ticket_number' => $regularTicket->ticket_number ?? null,
            'regular_department' => $regularTicket->department->name ?? 'N/A',
            'regular_doctor' => $regularTicket->doctor->name ?? 'N/A',
            'regular_waiting_count' => $regularWaitingCount
        ]);
    }
}