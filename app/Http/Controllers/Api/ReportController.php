<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getReportAttendance(Request $request)
    {
        // $param = $request->all();
        // $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m');
        
        // $dataReport = Employee::getReportDataAttendance($dateFilter);
        // $dateInMonth = Employee::getDayInMonth($dateFilter);
        // return response()->json([
        //     'status_code' => 200,
        //     'message' => 'SUCCESS', 
        //     'data_reports' => $dataReport,
        //     'date_in_months' => $dateInMonth
        //     ] ,200);
    }
}
