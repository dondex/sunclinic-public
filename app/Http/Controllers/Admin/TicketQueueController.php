<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketQueueController extends Controller
{
    public function index()
    {
        $regularTickets = Ticket::where('is_priority', false)
            ->orderBy('position')
            ->get();

        $priorityTickets = Ticket::where('is_priority', true)
            ->orderBy('position')
            ->get();

        $regularCurrent = Ticket::where('status', 'processing')
            ->where('is_priority', false)
            ->first();

        $priorityCurrent = Ticket::where('status', 'processing')
            ->where('is_priority', true)
            ->first();

        $completedTickets = Ticket::where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get();
            
        // Get all departments and doctors for filters
        $departments = Department::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();

        return view('admin.tickets.index', [
            'regularTickets' => $regularTickets,
            'priorityTickets' => $priorityTickets,
            'regularCurrent' => $regularCurrent,
            'priorityCurrent' => $priorityCurrent,
            'completedTickets' => $completedTickets,
            'departments' => $departments,
            'doctors' => $doctors
        ]);
    }

    public function priorityDisplay()
    {
        $currentPriorityTicket = Ticket::where('status', 'processing')
            ->where('is_priority', true)
            ->first();

        $priorityTickets = Ticket::where('is_priority', true)
            ->orderBy('position')
            ->get();

        $waitingCount = Ticket::where('status', 'waiting')
            ->where('is_priority', true)
            ->count();

        return view('admin.tickets.priority-display', [
            'currentPriorityTicket' => $currentPriorityTicket,
            'priorityTickets' => $priorityTickets,
            'waitingCount' => $waitingCount
        ]);
    }

    public function regularDisplay()
    {
        $currentRegularTicket = Ticket::where('status', 'processing')
            ->where('is_priority', false)
            ->first();

        $regularTickets = Ticket::where('is_priority', false)
            ->orderBy('position')
            ->get();

        $waitingCount = Ticket::where('status', 'waiting')
            ->where('is_priority', false)
            ->count();

        return view('admin.tickets.regular-display', [
            'currentRegularTicket' => $currentRegularTicket,
            'regularTickets' => $regularTickets,
            'waitingCount' => $waitingCount
        ]);
    }

    public function prioritize($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        DB::transaction(function () use ($ticket) {
            $ticket->update([
                'is_priority' => true,
                'position' => Ticket::where('is_priority', true)->max('position') + 1 ?? 1
            ]);
        });

        return response()->json(['message' => 'Ticket prioritized']);
    }

    public function removePriority($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        DB::transaction(function () use ($ticket) {
            $ticket->update([
                'is_priority' => false,
                'position' => Ticket::where('is_priority', false)->max('position') + 1 ?? 1
            ]);
        });

        return response()->json(['message' => 'Priority removed']);
    }

    public function regularNext(Request $request)
    {
        return $this->handleNextQueue(false, $request->current_ticket_id);
    }

    public function regularPrevious(Request $request)
    {
        return $this->handlePreviousQueue(false, $request->current_ticket_id);
    }

    public function priorityNext(Request $request)
    {
        return $this->handleNextQueue(true, $request->current_ticket_id);
    }

    public function priorityPrevious(Request $request)
    {
        return $this->handlePreviousQueue(true, $request->current_ticket_id);
    }

    private function handleNextQueue($isPriority, $currentTicketId = null)
    {
        return DB::transaction(function () use ($isPriority, $currentTicketId) {
            if ($currentTicketId) {
                // If there's a current ticket ID, mark it as completed
                $current = Ticket::find($currentTicketId);
                if ($current) {
                    $current->update(['status' => 'completed']);
                }
            } else {
                // If there's no current ticket ID but there's a processing ticket, mark it as completed
                $current = Ticket::where('status', 'processing')
                    ->where('is_priority', $isPriority)
                    ->first();
                if ($current) {
                    $current->update(['status' => 'completed']);
                }
            }

            // Find next waiting ticket
            $nextTicket = Ticket::where('status', 'waiting')
                ->where('is_priority', $isPriority)
                ->orderBy('position')
                ->first();

            if ($nextTicket) {
                $nextTicket->update(['status' => 'processing']);
                return response()->json($nextTicket);
            }

            return response()->json(['message' => 'No more tickets'], 404);
        });
    }

    private function handlePreviousQueue($isPriority, $currentTicketId = null)
    {
        return DB::transaction(function () use ($isPriority, $currentTicketId) {
            $current = null;
            
            if ($currentTicketId) {
                $current = Ticket::find($currentTicketId);
            } else {
                $current = Ticket::where('status', 'processing')
                    ->where('is_priority', $isPriority)
                    ->first();
            }

            if ($current) {
                $previousTicket = Ticket::where('status', 'completed')
                    ->where('is_priority', $isPriority)
                    ->orderByDesc('updated_at')  // Get the most recently completed
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
            // Reset all tickets to waiting status
            Ticket::query()->update(['status' => 'waiting']);

            // Reset regular positions
            $regularTickets = Ticket::where('is_priority', false)
                ->orderBy('created_at')
                ->get();
            $position = 1;
            foreach ($regularTickets as $ticket) {
                $ticket->update(['position' => $position]);
                $position++;
            }

            // Reset priority positions
            $priorityTickets = Ticket::where('is_priority', true)
                ->orderBy('created_at')
                ->get();
            $position = 1;
            foreach ($priorityTickets as $ticket) {
                $ticket->update(['position' => $position]);
                $position++;
            }
        });

        return redirect()->route('admin.tickets.index')
            ->with('success', 'All queues have been restarted. Positions reset to sequential order.');
    }

    public function showSpecific($id)
    {
        return DB::transaction(function () use ($id) {
            $requestedTicket = Ticket::findOrFail($id);
            
            // Only change status of current processing ticket of the same type 
            // (priority or regular) to avoid affecting the other queue
            $currentTicket = Ticket::where('status', 'processing')
                ->where('is_priority', $requestedTicket->is_priority)
                ->first();

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

    public function checkStatus(Ticket $ticket)
    {
        return response()->json([
            'success' => true,
            'ticket' => $ticket->fresh(['department', 'doctor'])
        ]);
    }
    
    // New methods for filtering
    public function filterByDepartment(Request $request)
    {
        $departmentId = $request->department_id;
        
        $query = Ticket::query();
        
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        
        $tickets = $query->orderBy('is_priority', 'desc')
                        ->orderBy('position')
                        ->get();
                        
        return response()->json([
            'success' => true,
            'tickets' => $tickets->load(['department', 'doctor'])
        ]);
    }
    
    public function filterByDoctor(Request $request)
    {
        $doctorId = $request->doctor_id;
        
        $query = Ticket::query();
        
        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }
        
        $tickets = $query->orderBy('is_priority', 'desc')
                        ->orderBy('position')
                        ->get();
                        
        return response()->json([
            'success' => true,
            'tickets' => $tickets->load(['department', 'doctor'])
        ]);
    }
    
    public function search(Request $request)
    {
        $searchTerm = $request->search;
        
        $tickets = Ticket::where('ticket_number', 'like', "%{$searchTerm}%")
                        ->orderBy('is_priority', 'desc')
                        ->orderBy('position')
                        ->get();
                        
        return response()->json([
            'success' => true,
            'tickets' => $tickets->load(['department', 'doctor'])
        ]);
    }
}