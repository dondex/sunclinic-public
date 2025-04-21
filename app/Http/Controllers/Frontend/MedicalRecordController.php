<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index($user_id)
    {

        $user = User::findOrFail($user_id);

        $records = Record::where('user_id', $user_id)->get();

        return view('frontend.medical-record.index', compact('user', 'records'));
    }
}
