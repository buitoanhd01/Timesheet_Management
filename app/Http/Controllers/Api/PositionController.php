<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    //
    public function getListPositions()
    {
        $listPositions = Position::getListPositions();
        if ($listPositions)
            return response()->json(['list_position' => $listPositions] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function deletePosition(Request $request)
    {
        $param = $request->all();
        if (isset($param['id'])) {
            $position = Position::find($param['id']);
            $employeeHasId = Employee::deleteEmployeeUserPositionID($param['id']);
            $position->delete();
            return response()->json(['status_code' => 200, 'message' => 'DELETED SUCCESSFULLY'] ,200);
        }
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }
}
