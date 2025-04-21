<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($user_id)
    {

        $user = User::findOrFail($user_id);

        $records = Record::where('user_id', $user_id)->get();

        return view('frontend.profile.index', compact('user', 'records'));
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        $records = Record::where('user_id', $user_id)->get();

        // If no records exist, redirect to the profile index with a message
        if ($records->isEmpty()) {
            return redirect('profile/' . $user_id)->with('error', 'No records found. The admin is responsible for setting your record.');
        }

        return view('frontend.profile.edit', compact('user', 'records'));
    }

    public function update(Request $request, $user_id)
    {
        $request->validate([
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
        ]);
    
        // Fetch the first record associated with the user
        $record = Record::where('user_id', $user_id)->first();
    
        // If no record exists, create a new one
        if (!$record) {
            $record = new Record();
            $record->user_id = $user_id; // Set the user_id for the new record
        }
    
        // Update the record fields
        $record->phone_number = $request->phone_number;
        $record->address = $request->address;
        $record->gender = $request->gender;
        $record->save();
    
        // Redirect to the profile page of the user
        return redirect('profile/' . $user_id)->with('message', 'Profile Updated Successfully');
    }
}
