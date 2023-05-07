<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function getListEmployees(Request $request)
    {
        $param = $request->all();
        $dataFilter = isset($param['dataFilter']) ? $param['dataFilter'] : null;
        $listEmployee = Employee::getListEmployees($dataFilter);
        if ($listEmployee)
            return response()->json(['list_employee' => $listEmployee] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function deleteEmployee(Request $request)
    {
        $param = $request->all();
        if (isset($param['id'])) {
            $employeeDelete = Employee::find($param['id']);
            if ($employeeDelete->user_id == auth()->user()->id) {
                return response()->json(['status_code' => 401, 'message' => 'CANT DELETE YOURSELF'] ,400);
            }
            // $attendance = Attendance::deleteAttendanceDataByEmployeeID($param['id']);
            $userDeleted = User::find($employeeDelete->user_id);
            if (isset($userDeleted)) {
                $userDeleted->syncRoles([]);
                $userDeleted->delete();
            }
            $employeeDelete->delete();
            return response()->json(['status_code' => 200, 'message' => 'DELETED SUCCESSFULLY'] ,200);
        }
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }
}
