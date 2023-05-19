<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function updateShift(Request $request)
    {
        $param = $request->all();
        $data = [
            'id' => $param['id'],
            'shift_name'            => $param['shift_name'],
            'shift_start_time'      => date('H:i:s', strtotime($param['shift_start'])),
            'shift_end_time'        => date('H:i:s', strtotime($param['shift_end'])),
            'shift_rest_time_start' => date('H:i:s', strtotime($param['rest_start'])),
            'shift_rest_time_end'   => date('H:i:s', strtotime($param['rest_end'])),
            'time_start_overtime'   => date('H:i:s', strtotime($param['overtime'])),
        ];
        $shift = Shift::updateOrCreate(
            ['id' => $data['id']],
            $data
        );
        if ($shift)
                return response()->json(['status_code' => 200] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }
}
