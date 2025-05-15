<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model 
{
    use HasFactory;
    
    protected $fillable = [
        'ticket_number',
        'department_id',
        'doctor_id',
        'patient_id',
        'is_priority',
        'status',
        'position',
        'source', // New field to track if ticket is from appointment or walk-in
    ];
    
    protected static function booted()
    {
        static::creating(function ($ticket) {
            // Auto-assign position when creating new ticket
            $ticket->position = Ticket::max('position') + 1;
        });
    }
    
    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}