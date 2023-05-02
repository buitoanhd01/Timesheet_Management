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
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : '';
        $searchValue = trim($searchValue);
        $dataFilter = (isset($param['dataFilter'])) ? $param['dataFilter'] : '';
        $listCalendars = Employee::getListCalendars($dateFilter, $currentTab, $searchValue, $dataFilter);
        $count = [];
        $count['ArrivalLate'] = 0;
        $count['LeaveEarly'] = 0;
        $count['Both'] = 0;
        foreach ($listCalendars as $calendar)
        {
            switch ($calendar['status']) {
                case 1:
                    $count['ArrivalLate']++;
                    break;
                case 2:
                    $count['LeaveEarly']++;
                    break;
                case 3:
                    $count['Both']++;
                    break;
            }
        }
        if ($listCalendars)
            return response()->json(['list_calendar' => $listCalendars, 'count' => $count] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
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

    public function getAttendanceByEmployeeID(Request $request)
    {
        $param = $request->all();
        $employeeID = Employee::getCurrentEmployeeID();
        $currentTab = (isset($param['current_tab'])) ? $param['current_tab'] : 'daily';
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m-d');
        $dataFilter = (isset($param['dataFilter'])) ? $param['dataFilter'] : '';
        $listCalendars = Employee::getListCalendarsByEmployeeID($dateFilter, $currentTab, $employeeID, $dataFilter);
        $count = [];
        $count['ArrivalLate'] = 0;
        $count['LeaveEarly'] = 0;
        $count['Both'] = 0;
        foreach ($listCalendars as $calendar)
        {
            switch ($calendar['status']) {
                case 1:
                    $count['ArrivalLate']++;
                    break;
                case 2:
                    $count['LeaveEarly']++;
                    break;
                case 3:
                    $count['Both']++;
                    break;
            }
        }
        if ($listCalendars)
            return response()->json(['list_calendar' => $listCalendars, 'count' => $count] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function getDashboardCalendar()
    {
        $employee_id = Employee::getCurrentEmployeeID();
        $attendance = Attendance::where(['employee_id' => $employee_id, 'date' => date('Y-m-d')])->first();
        if ($attendance)
            return response()->json(['attendance' => $attendance] ,200);
        return response()->json(['status_code' => 401, 'message' => 'No DATA'] ,200);
    }
}
