<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    //
    public function index()
    {
        return view('admin.calendar.calendar-manager');
    }

    public function getSelfAttendance()
    {
        return view('employee.attendance.my-attendance');
    }
}
