<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class MyAppointmentController extends Controller
{
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);

        $appointments = Appointment::where('user_id', $user_id)->get();
      
        return view('frontend.appointment.index', compact('user', 'appointments'));
    }
}
