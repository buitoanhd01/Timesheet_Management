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
        $id = Employee::getCurrentEmployeeID();
        $listRequests = Leave::getLeavesByEmployeeId($id, $dataFilter);
            return response()->json(['status_code' => 200, 'message' => 'SUCCESS', 'list_requests' => $listRequests] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }
}
