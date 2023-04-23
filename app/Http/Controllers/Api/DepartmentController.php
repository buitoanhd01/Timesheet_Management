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
}
