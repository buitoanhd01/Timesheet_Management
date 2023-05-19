<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Setting;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('admin.employee-management.employee-list');
    }

    public function showCreateEmployeeForm(Request $request)
    {
        $data['department'] = Department::all();
        $data['position']   = Position::getListPositionsAvailable();
        $data['role'] = Role::all();
        return view('admin.employee-management.employee-create', [
            'roles'             => $data['role'],
            'positions'         => $data['position'],
            'departments'       => $data['department']
        ]);
    }

    public function createEmployee(Request $request)
    {
        $validator = $request->validate([
            'firstName'     => 'required|alpha|max:255',
            'lastName'      => 'required|alpha|max:255',
            'fullName'      => 'required|max:255',
            'email'         => 'required|email',
            'employee_code' => 'required|unique:employees,employee_code',
            'tax_code'      => 'required|numeric',
            'phoneNumber'   => 'required|regex:/^[0-9]{10,11}$/',
            'address'       => 'required',
            'start_time'    => 'required|date',
            'birthday'      => 'date',
            'position'      => $request->filled('position') ? [Rule::exists('positions', 'id')] : '',
            'department'    => $request->filled('department') ? [Rule::exists('departments', 'id')] : '',
        ]);
        $params = $request->all();
        if (isset($params['newAccount'])) {
            $request->validate([
                'username'      => 'required|max:255|unique:users,username',
            ]);
            $id = DB::table('users')->insertGetId([
                'username'    => $request->input('username'),
                'password' => Hash::make(Setting::getDefaultPassword()),
                'status'   => 'active',
            ]);
            $user = User::find($id);
            $user->assignRole($params['role']);
        } else {
            $id = -1;
        }
        $employee = new Employee([
            'first_name'    =>  $request->input('firstName'),
            'last_name'     =>  $request->input('lastName'),
            'full_name'     =>  $request->input('fullName'),
            'email'         =>  $params['email'],
            'employee_code' =>  $request->input('employee_code'),
            'tax_code'      =>  $request->input('tax_code'),
            'phone'         =>  $request->input('phoneNumber'),
            'address'       =>  $request->input('address'),
            'birthday'      =>  date('Y-m-d', strtotime($request->input('birthday'))),
            'gender'        =>  $request->input('gender'),
            'start_time'    =>  date('Y-m-d', strtotime($request->input('start_time'))),
            'end_time'      =>  date('Y-m-d', strtotime($request->input('end_time'))),
            'employee_type' =>  $request->input('employee_type'),
            'position_id'   =>  $request->input('position'),
            'department_id' =>  $request->input('department'),
            'status'        => 'working',
            'user_id'       =>  $id, 
        ]);
        $employee->save();

        return redirect()->route('admin-employee')->with('success', 'Thêm nhân viên thành công!');
    }

    public function showEditEmployeeForm(Request $request, $id)
    {
        $employee = Employee::getEmployeeByID($id);
        $user = User::find($employee->user_id);
        $position = Position::getListPositionsAvailable();
        $department = Department::all();
        return view('admin.employee-management.employee-edit', 
        [
            'employee'      =>   $employee,
            'positions'     =>   $position,
            'departments'   =>   $department,
            'user'          =>   $user,
        ]);
    }

    public function editEmployee(Request $request, $id)
    {
        $validator = $request->validate([
            'firstName'     => 'required|alpha|max:255',
            'lastName'      => 'required|alpha|max:255',
            'fullName'      => 'required||max:255',
            'email'         => 'required|email',
            'tax_code'      => 'required|numeric',
            'phoneNumber'   => 'required|regex:/^[0-9]{10,11}$/',
            'address'       => 'required',
            'start_time'    => 'required|date',
            'birthday'      => 'date',
        ]);

        $employee = Employee::find($id);
        $employee->first_name    = $request->input('firstName');
        $employee->last_name     = $request->input('lastName');
        $employee->full_name     = $request->input('fullName');
        $employee->email         = $request->input('email');
        $employee->tax_code      = $request->input('tax_code');
        $employee->phone         = $request->input('phoneNumber');
        $employee->address       = $request->input('address');
        $employee->birthday      = date('Y-m-d', strtotime($request->input('birthday')));
        $employee->gender        = $request->input('gender');
        $employee->start_time    = date('Y-m-d', strtotime($request->input('start_time')));
        $employee->end_time      = date('Y-m-d', strtotime($request->input('end_time')));
        $employee->employee_type = $request->input('employee_type');
        $employee->position_id   = $request->input('position');
        $employee->department_id = $request->input('department');
        $employee->status        =$request->input('status');
        $employee->save();

        return redirect()->route('admin-employee')->with('success', 'Sửa nhân viên thành công!');
    }

    public function showMyEditEmployeeForm(Request $request)
    {
        $id = Employee::getCurrentEmployeeID();
        $employee = Employee::getEmployeeByID($id);
        $user = User::find($employee->user_id);
        $position = Position::all();
        $department = Department::all();
        return view('admin.employee-management.employee-profile', 
        [
            'employee'      =>   $employee,
            'positions'     =>   $position,
            'departments'   =>   $department,
            'user'          =>   $user,
        ]);
    }
}
