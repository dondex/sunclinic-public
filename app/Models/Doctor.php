<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Specify the fields that can be mass assigned
    protected $fillable = ['name', 'department_id'];

    // Define the relationship with the Department model
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}