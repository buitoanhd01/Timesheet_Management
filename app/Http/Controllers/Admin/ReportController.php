<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.report-list');
    }

    public function reportSelf()
    {
        return view('employee.report.my-report');
    }

    public function getReportAttendance(Request $request)
    {
        $param = $request->all();
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m');
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : null;
        $dataReport = Employee::getReportDataAttendance($dateFilter, $searchValue);
        $dateInMonth = Employee::getDayInMonth($dateFilter);
        $dateNew = [];
        foreach($dateInMonth as $key => $date) {
            $dateNew[$key] = date('d', strtotime($date));
        }
        $html = view('admin.report.report-table', [
            'data_reports' => $dataReport,
            'date_in_months' => $dateNew,
            'date_data' => $dateInMonth
            ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function getReportOvertime(Request $request)
    {
        $param = $request->all();
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m');
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : null;
        $dataReport = Employee::getReportDataOvertime($dateFilter, $searchValue);
        $dateInMonth = Employee::getDayInMonth($dateFilter);
        $dateNew = [];
        foreach($dateInMonth as $key => $date) {
            $dateNew[$key] = date('d', strtotime($date));
        }
        $html = view('admin.report.report-table', [
            'data_reports' => $dataReport,
            'date_in_months' => $dateNew,
            'date_data' => $dateInMonth
            ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function getReportTotal(Request $request)
    {
        $param = $request->all();
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m');
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : null;
        $dataReport = Employee::getReportDataTotal($dateFilter, $searchValue);
        $dateInMonth = Employee::getDayInMonth($dateFilter);
        $dateNew = [];
        foreach($dateInMonth as $key => $date) {
            $dateNew[$key] = date('d', strtotime($date));
        }
        $html = view('admin.report.report-table', [
            'data_reports' => $dataReport,
            'date_in_months' => $dateNew,
            'date_data' => $dateInMonth
            ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function getReportAttendanceByID(Request $request)
    {
        $param = $request->all();
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m');
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : null;
        $dataReport = Employee::getReportDataAttendanceByID($dateFilter, $searchValue);
        $dateInMonth = Employee::getDayInMonth($dateFilter);
        $dateNew = [];
        foreach($dateInMonth as $key => $date) {
            $dateNew[$key] = date('d', strtotime($date));
        }
        $html = view('admin.report.report-table', [
            'data_reports' => $dataReport,
            'date_in_months' => $dateNew,
            'date_data' => $dateInMonth
            ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function getReportOvertimeByID(Request $request)
    {
        $param = $request->all();
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m');
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : null;
        $dataReport = Employee::getReportDataOvertimeByID($dateFilter, $searchValue);
        $dateInMonth = Employee::getDayInMonth($dateFilter);
        $dateNew = [];
        foreach($dateInMonth as $key => $date) {
            $dateNew[$key] = date('d', strtotime($date));
        }
        $html = view('admin.report.report-table', [
            'data_reports' => $dataReport,
            'date_in_months' => $dateNew,
            'date_data' => $dateInMonth
            ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function getReportTotalByID(Request $request)
    {
        $param = $request->all();
        $dateFilter = (isset($param['dateFilter'])) ? $param['dateFilter'] : date('Y-m');
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : null;
        $dataReport = Employee::getReportDataTotalByID($dateFilter, $searchValue);
        $dateInMonth = Employee::getDayInMonth($dateFilter);
        $dateNew = [];
        foreach($dateInMonth as $key => $date) {
            $dateNew[$key] = date('d', strtotime($date));
        }
        $html = view('admin.report.report-table', [
            'data_reports' => $dataReport,
            'date_in_months' => $dateNew,
            'date_data' => $dateInMonth
            ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}
