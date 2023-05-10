<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('admin.department.department-list');
    }

    public function showCreateDepartmentForm()
    {
        return view('admin.department.department-create');
    }

    public function addNewDepartment(Request $request)
    {
        $validate = $request->validate([
            'department_name' => ['required', 'string', 'max:255', 'unique:departments'],
            'department_description' => ['string', 'max:255'],
        ]);
        $department = new Department([
            'department_name' => $request->input('department_name'),
            'department_description' => $request->input('department_description'),
        ]);

        $department->save();
        return redirect()->route('admin-department-management')->with('success', 'Thêm Phòng Ban thành công!');
    }

    public function showEditDepartmentForm(Request $request, $id)
    {
        $department = Department::find($id);
        return view('admin.department.department-edit',['department' => $department]);
    }

    public function editDepartment(Request $request, $id)
    {
        $validate = $request->validate([
            'department_name' => ['required', 'string', 'max:255'],
            'department_description' => ['string', 'max:255'],
        ]);
        $department = Department::find($id);
        $department->department_name = $request->input('department_name');
        $department->department_description = $request->input('department_description');

        $department->save();
        return redirect()->route('admin-department-management')->with('success', 'Sửa Phòng Ban thành công!');
    }
}
