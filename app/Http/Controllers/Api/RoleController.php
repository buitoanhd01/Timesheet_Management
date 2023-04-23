<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function getListRoles()
    {
        $listRole = Role::all();
        if ($listRole)
            return response()->json(['list_roles' => $listRole] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function addRole(Request $request)
    {
        $param = $request->all();
        $validate = $request->validate([
           'role_name' => ['required', 'string', 'max:50', 'unique:roles,name'],
        ]);
        $role = Role::create(['name' => $param['role_name'], 'guard_name' => 'web']);

        if (isset($param['roles'])) {
            foreach($param['roles'] as $r) {
                $role->givePermissionTo($r);
            }
        }
        // Gán permission cho role
        if ($role)
            return response()->json(['status_code' => 200, 'message' => 'SUCCESS'] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function deleteRole(Request $request)
    {
        $param = $request->all();
        $deleteRoleId = User::deleteRoleId($param['role_id']);
        $role = Role::find($param['role_id']);
        $role->delete();
        return response()->json(['status_code' => 200, 'message' => 'SUCCESS'] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }
}
