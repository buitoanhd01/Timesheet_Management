<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $param = $request->all();
        $currentTab = (isset($param['current_tab'])) ? $param['current_tab'] : 'daily';
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('d-m-Y');
        $listCalendars = Employee::getListCalendars($dateFilter, $currentTab);
        // dd($listCalendars);
        return response()->json(['list_calendar' => $listCalendars] ,200);
    }

    public function insertAttendance(Request $request)
    {
        $param = $request->all();
        $param['time_checkin'] = (isset($param['type_check']) && $param['type_check'] == 'check_in') ? date('Y-m-d H:i:s') : "null";
        $param['time_checkout'] = (isset($param['type_check']) && $param['type_check'] == 'check_out') ? date('Y-m-d H:i:s') : "null";
        $checkIn = Attendance::getPersonalCheckInOutNow();
        if ($checkIn['first_checkin'] != 'null' && $param['time_checkin'] != 'null') {
            return response()->json(['status_code' => 222, 'message' => 'CHECKED IN'] ,200);
        }
        $minuteDelay = Attendance::compareAndGetMinuteStrTime($param['time_checkout'], $checkIn['last_checkout']);
        if (isset($minuteDelay) && $minuteDelay != 0) {
            return response()->json(['minute_delay' => $minuteDelay, 'status_code' => 333, 'message' => 'CHECK OUT OVER FAST'] ,200);
        }
        $param['date'] = date('Y-m-d');
        $data = Attendance::InsertOrUpdateAttendance($param);
        if ($data) {
            return response()->json(['response' => $data, 'status_code' => 200, 'message' => 'SUCCESS'] ,200);
        }
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function getSelfAttendanceNow(Request $request)
    {
        $data = Attendance::getPersonalCheckInOutNow();
        if ($data) {
            return response()->json(['response' => $data, 'status_code' => 200, 'message' => 'SUCCESS'] ,200);
        }
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
