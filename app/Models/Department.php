<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'image',
        'icon',
        'description'
    ];

    // Define the relationship with the Doctor model
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    
}
