<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class SingleDeptController extends Controller
{
    public function index($id)
    {
        
        // Retrieve the department by ID
        $department = Department::findOrFail($id);

        // Return the view with the department data
        return view('frontend.department.index', compact('department'));
    }
}
