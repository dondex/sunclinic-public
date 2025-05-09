<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Validate the incoming request data
        $request->validate([
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'birthday' => 'required|date', // Validate the birthday field
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the profile image
        ]);
    
        // Fetch the first record associated with the user
        $record = Record::where('user_id', $user_id)->first();
    
        // If no record exists, create a new one
        if (!$record) {
            $record = new Record();
            $record->user_id = $user_id; // Set the user_id for the new record
            $record->resident_number = Auth::user()->resident_number; // Set resident number from authenticated user
        }
    
        // Update the record fields
        $record->phone_number = $request->phone_number;
        $record->address = $request->address;
        $record->gender = $request->gender;
        $record->birthday = $request->birthday; // Set birthday
    
        // Handle the profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($record->profile_image) {
                unlink(public_path($record->profile_image));
            }
    
            // Upload the new profile image
            $profilePicture = $request->file('profile_image');
            $filename = time() . '_profile.' . $profilePicture->getClientOriginalExtension();
            $profilePicture->move(public_path('uploads/profile_pictures'), $filename);
            $record->profile_image = 'uploads/profile_pictures/' . $filename; // Store the path in the database
        }
    
        // Save the record to the database
        $record->save();
    
        // Redirect to the profile page of the user
        return redirect('profile/' . $user_id)->with('message', 'Profile Updated Successfully');
    }

    public function store(Request $request, $user_id)
    {
        // Validate the incoming request data
        $request->validate([
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'birthday' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Create a new record
        $record = new Record();
        $record->user_id = $user_id;
        $record->phone_number = $request->phone_number;
        $record->address = $request->address;
        $record->gender = $request->gender;
        $record->birthday = $request->birthday;
        $record->resident_number = Auth::user()->resident_number; // Set resident number from authenticated user
    
               // Handle the profile image upload
               if ($request->hasFile('profile_image')) {
                // Upload the new profile image
                $profilePicture = $request->file('profile_image');
                $filename = time() . '_profile.' . $profilePicture->getClientOriginalExtension();
                $profilePicture->move(public_path('uploads/profile_pictures'), $filename);
                $record->profile_image = 'uploads/profile_pictures/' . $filename; // Store the path in the database
            }
        
            // Save the record to the database
            if ($record->save()) {
                return redirect('profile/' . $user_id)->with('message', 'Profile Created Successfully');
            } else {
                return redirect('profile/' . $user_id)->with('error', 'Failed to create profile.');
            }
        }
    }
    