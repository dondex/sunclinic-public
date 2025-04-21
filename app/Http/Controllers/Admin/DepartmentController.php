<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentFormRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DepartmentController extends Controller
{
    public function index()
    {
        $department = Department::all();
        return view('admin.department.index', compact('department'));
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(DepartmentFormRequest $request)
    {
       
        $data = $request->validated();

        
        $department = new Department;

      
        $department->name = $data['name'];
        $department->icon = $data['icon'];
        $department->description = $data['description'];

        // Handle the image upload
        if ($request->hasFile('image')) {
           $file = $request->file('image');
           $filename = time() . '.' . $file->getClientOriginalExtension();
           $file->move('uploads/department/', $filename);
           $department->image = $filename;
        }

        
        $department->save();

        
        return redirect('admin/department')->with('message', 'Department Added Successfully.');
    }

    public function edit($department_id)
    {
        $department = Department::find($department_id);
        return view('admin.department.edit', compact('department'));
    }

    public function update(DepartmentFormRequest $request, $department_id )
    {
        $data = $request->validated();

        
        $department = Department::find($department_id);

      
        $department->name = $data['name'];
        $department->icon = $data['icon'];
        $department->description = $data['description'];

        // Handle the lab results image upload
        if ($request->hasFile('lab_results_image')) {
            // Define the destination path
            $destination = 'uploads/lab_results/' . ($record->lab_results_image ?? '');
            
            // Delete the existing image if it exists
            if (File::exists($destination)) {
                File::delete($destination);
            }

            // Upload the new image
            $file = $request->file('lab_results_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/lab_results/', $filename);
            $record->lab_results_image = $filename;
        }

        // Handle the imaging studies image upload
        if ($request->hasFile('imaging_studies_image')) {
            // Define the destination path
            $destination = 'uploads/imaging_studies/' . ($record->imaging_studies_image ?? '');
            
            // Delete the existing image if it exists
            if (File::exists($destination)) {
                File::delete($destination);
            }

            // Upload the new image
            $file = $request->file('imaging_studies_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/imaging_studies/', $filename);
            $record->imaging_studies_image = $filename;
        }

        
        $department->update();

        return redirect('admin/department')->with('message', 'Department Updated Successfully.');
    }

    public function destroy($department_id)
    {
        $department = Department::find($department_id);
        if($department)
        {

            $destination = 'uploads/department/'.$department->image;
            if(File::exists($destination)){
                File::delete($destination);
            }


            $department->delete();
            return redirect('admin/department')->with('message', 'Department Deleted Successfully.');
        }
        else
        {
            return redirect('admin/department')->with('message', 'No Department ID Found.');
        }
    }
}



