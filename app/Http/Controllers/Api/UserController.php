<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getListUsers(Request $request)
    {
        $param = $request->all();
        $listUser = User::getAllUsersActive();
        if ($listUser)
            return response()->json(['list_user' => $listUser] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function deleteUser(Request $request)
    {
        $param = $request->all();
        if (isset($param['id'])) {
            $employeeHasId = Employee::deleteEmployeeUserID($param['id']);
            $userDeleted = User::find($param['id']);
            $userDeleted->syncRoles([]);
            $userDeleted->delete();
            return response()->json(['status_code' => 200, 'message' => 'DELETED SUCCESSFULLY'] ,200);
        }
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }
}
