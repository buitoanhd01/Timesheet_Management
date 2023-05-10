<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function getListDepartments()
    {
        $listDepartment = Department::getListDepartments();
        if ($listDepartment)
            return response()->json(['list_department' => $listDepartment] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function deleteDepartment(Request $request)
    {
        $param = $request->all();
        if (isset($param['id'])) {
            $department = Department::find($param['id']);
            $department->delete();
            return response()->json(['status_code' => 200, 'message' => 'DELETED SUCCESSFULLY'] ,200);
        }
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }
}
