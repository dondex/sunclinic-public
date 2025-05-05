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
        $currentTicket = Ticket::with(['department', 'doctor'])
            ->where('status', 'processing')
            ->first();

        return response()->json([
            'ticket_number' => $currentTicket->ticket_number ?? null,
            'department' => $currentTicket->department->name ?? 'N/A',
            'doctor' => $currentTicket->doctor->name ?? 'N/A'
        ]);
    }
}