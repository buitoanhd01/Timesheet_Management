<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function getSelfRequest(Request $request)
    {
        $param = $request->all();
        $dataFilter = isset($param['dataFilter']) ? $param['dataFilter'] : 'all';
        $dateFilter = isset($param['dateFilter']) ? date('Y-m',strtotime($param['dateFilter'])) : date('Y-m');
        $id = Employee::getCurrentEmployeeID();
        $listRequests = Leave::getLeavesByEmployeeId($id, $dataFilter, $dateFilter);
            return response()->json(['status_code' => 200, 'message' => 'SUCCESS', 'list_requests' => $listRequests] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function getAllRequest(Request $request)
    {
        $param = $request->all();
        $dataFilter = isset($param['dataFilter']) ? $param['dataFilter'] : 'all';
        $dateFilter = isset($param['dateFilter']) ? date('Y-m',strtotime($param['dateFilter'])) : date('Y-m');
        $listRequests = Leave::getAllLeaveRequests($dataFilter, $dateFilter);
            return response()->json(['status_code' => 200, 'message' => 'SUCCESS', 'list_requests' => $listRequests] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function createNewRequest(Request $request)
    {
        $param = $request->all();
        $employee_id = Employee::getCurrentEmployeeID();
        $leave = Leave::create(['employee_id'       => $employee_id,
                                'leave_date_start'  => $param['start_date'],
                                'leave_date_end'    => $param['end_date'],
                                'leave_type'        => $param['leave_type'],
                                'reason'            => $param['reason'],
                                'time_sent_request' => date('Y-m-d H:i:s')]);
        if ($leave)
            return response()->json(['status_code' => 200, 'message' => 'SUCCESS'] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function updateStatusRequest(Request $request)
    {
        $param = $request->all();
        $id = isset($param['id']) ? $param['id'] : '';
        $status = isset($param['status']) ? $param['status'] : '0';
        $statusRequest = Leave::updateStatusByID($id, $status);
        if ($statusRequest)
            return response()->json(['status_code' => 200, 'message' => 'SUCCESS'] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function updateRequest(Request $request)
    {
        $param = $request->all();
        $leave = Leave::find($param['id']);
        $leave->leave_date_start = $param['start_date'];
        $leave->leave_date_end   = $param['end_date'];
        $leave->reason           = $param['reason'];
        $leave->leave_type       = $param['leave_type'];
        $leave->status           = 0;
        $leave->save();
        return response()->json(['status_code' => 200, 'message' => 'SUCCESS'] ,200);
    }

    public function deleteRequest(Request $request)
    {
        $param = $request->all();
        $leave = Leave::find($param['id']);
        $leave->delete();
        return response()->json(['status_code' => 200, 'message' => 'SUCCESS'] ,200);
    }
}
