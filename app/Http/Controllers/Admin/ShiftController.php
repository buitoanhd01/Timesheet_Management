<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        return view('admin.shift.shift-manager');
    }

    public function getAllListShifts(Request $request)
    {
        $param = $request->all();
        $searchValue = (isset($param['searchValue'])) ? $param['searchValue'] : null;
        $listShift = Shift::getShiftAllEmployees($searchValue);
        $html = view('admin.shift.shift-list', [
            'list_shift' => $listShift
        ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function myShift()
    {
        return view('employee.shift.my-shift');
    }

    public function getEmployeeShift(Request $request)
    {
        $param = $request->all();
        $listShift = Shift::getShiftEmployeeByID();
        $html = view('employee.shift.shift-list', [
            'list_shift' => $listShift
        ])->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}
