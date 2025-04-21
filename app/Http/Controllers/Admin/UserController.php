<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_as', '0')->get();
        return view('admin.user.index', compact('users'));
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $user_id)
    {
        // Step 1: Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user_id,
            'resident_number' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15', // Adjust max length as needed
            'birthday' => 'required|date',
        ]);

        // Step 2: Find the user and update their information
        $user = User::find($user_id);
        
        if ($user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->resident_number = $request->input('resident_number');
            $user->phone_number = $request->input('phone_number');
            $user->birthday = $request->input('birthday');
            
            // Save the updated user
            $user->update();

            // Step 3: Redirect with a success message
            return redirect('admin/patients')->with('message', 'Patient Updated Successfully');
        }

        // If user not found, you might want to handle that case
        return redirect('admin/patients')->with('message', 'No Patient Found');
    }
    
}
