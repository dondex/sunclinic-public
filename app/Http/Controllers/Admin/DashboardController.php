<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $appointment = Appointment::count();
        $appointment1 = Appointment::where('status', 'Pending')->count();
        $appointment2 = Appointment::where('status', 'Accepted')->count();
        $user = User::where('role_as', '0')->count();

        return view('admin.dashboard', compact('appointment', 'user', 'appointment1', 'appointment2'));
    }
}
