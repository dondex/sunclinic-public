<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class AllDepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        return view('frontend.department.alldept', compact('departments'));
    }
}
