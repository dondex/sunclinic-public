<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketQueueController extends Controller
{
    public function index()
    {
        $tickets = Ticket::orderBy('position')->get();
        $currentTicket = Ticket::where('status', 'processing')->first();
        $completedTickets = Ticket::where('status', 'completed')
            ->orderBy('position', 'desc')
            ->get();

        $waitingCount = Ticket::where('status', 'waiting')->count();

        return view('admin.tickets.index', [
            'tickets' => $tickets,
            'currentTicket' => $currentTicket,
            'completedTickets' => $completedTickets,
            'waitingCount' => $waitingCount
        ]);
    }

    public function next(Request $request)
    {
        return DB::transaction(function () {
            $current = Ticket::where('status', 'processing')->first();

            if ($current) {
                $current->update(['status' => 'completed']);
            }

            // Always get the ticket with the lowest position
            $nextTicket = Ticket::where('status', 'waiting')
                ->orderBy('position')
                ->first();

            if ($nextTicket) {
                $nextTicket->update(['status' => 'processing']);
                return response()->json($nextTicket);
            }

            return response()->json(['message' => 'No more tickets'], 404);
        });
    }

    public function previous(Request $request)
    {
        return DB::transaction(function () {
            $current = Ticket::where('status', 'processing')->first();
            
            if ($current) {
                $previousTicket = Ticket::where('status', 'completed')
                    ->orderBy('position', 'desc')
                    ->first();

                if ($previousTicket) {
                    $current->update(['status' => 'waiting']);
                    $previousTicket->update(['status' => 'processing']);
                    return response()->json($previousTicket);
                }
            }

            return response()->json(['message' => 'No previous ticket'], 404);
        });
    }

    public function restart(Request $request)
    {
        DB::transaction(function () {
            // Reset all tickets to waiting
            Ticket::query()->update(['status' => 'waiting']);

            // Reset positions to be sequential
            $tickets = Ticket::orderBy('created_at')->get();
            $position = 1;
            
            foreach ($tickets as $ticket) {
                $ticket->update(['position' => $position]);
                $position++;
            }
        });

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Queue has been restarted. Positions reset to sequential order.');
    }

    public function showSpecific($id)
    {
        return DB::transaction(function () use ($id) {
            $requestedTicket = Ticket::findOrFail($id);
            $currentTicket = Ticket::where('status', 'processing')->first();

            if ($currentTicket && $currentTicket->id !== $requestedTicket->id) {
                $currentTicket->update(['status' => 'waiting']);
            }

            $requestedTicket->update(['status' => 'processing']);
            return redirect()->route('admin.tickets.index')
                ->with('success', "Now processing ticket {$requestedTicket->ticket_number}");
        });
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function display()
    {
        $currentTicket = Ticket::where('status', 'processing')->first();
        $waitingTickets = Ticket::where('status', 'waiting')
            ->orderBy('position')
            ->take(5)
            ->get();

        return view('admin.tickets.display', compact('currentTicket', 'waitingTickets'));
    }
}