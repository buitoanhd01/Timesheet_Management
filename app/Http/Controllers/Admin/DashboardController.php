<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::user()->id;
        $employee = Employee::where(['user_id' => $id])->first();
        $employee_id = $employee->id;
        $attendance = Attendance::where(['employee_id' => $employee_id, 'date' => date('Y-m-d')])->first();
        return view('admin.dashboard', ['employee' => $employee, 'attendance' => $attendance]);
    }
    
}
