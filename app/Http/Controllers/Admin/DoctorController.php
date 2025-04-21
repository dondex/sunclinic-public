<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DoctorFormRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('admin.doctor.index', compact('doctors'));
    }

    public function create()
    {
        $department = Department::all();
        return view('admin.doctor.create', compact('department'));
    }

    public function store(DoctorFormRequest $request)
    {
        $data = $request->validated();

        $doctor = new Doctor;
        $doctor->name = $data['name'];
        $doctor->department_id = $data['department_id'];

        $doctor->save();

        return redirect('admin/doctor')->with('message', 'Doctor Added Successfully');
    }

    public function edit($doctor_id)
    {
        $department = Department::all();
        $doctor = Doctor::find($doctor_id);
        return view('admin.doctor.edit', compact('doctor', 'department'));
    }

    public function update(DoctorFormRequest $request, $doctor_id)
    {
        $data = $request->validated();

        $doctor = Doctor::find($doctor_id);
        $doctor->name = $data['name'];
        $doctor->department_id = $data['department_id'];

        $doctor->update();

        return redirect('admin/doctor')->with('message', 'Doctor Updated Successfully');
    }

    public function destroy($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        $doctor->delete();

        return redirect('admin/doctor')->with('message', 'Doctor Deleted Successfully');
    }

    
}
