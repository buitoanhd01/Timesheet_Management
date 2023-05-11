<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
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
        $role = Role::find($param['role_id']);
        if ($role->name == 'super-admin') {
            return response()->json(['status_code' => 400, 'message' => 'CANT DELETE SUPERADMIN'] ,400);
        }
        $role->syncPermissions([]);
        $role->delete();
        return response()->json(['status_code' => 200, 'message' => 'SUCCESS'] ,200);
    }

    public function getListPermisionByRoleID(Request $request)
    {
        $param = $request->all();
        $id = $param['id'];
        $role = Role::find($id);
        $list_permision = $role->permissions->pluck('name');
        $all_permission = Permission::all()->pluck('name');
        if ($list_permision)
            return response()->json(['list_permision' => $list_permision, 'all_permission' => $all_permission, 'role' => $role->name] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function getListPermisionByUserID(Request $request)
    {
        $param = $request->all();
        $id = $param['id'];
        $user = User::find($id);
        $list_permision = $user->permissions->pluck('name');
        $all_permission = Permission::all()->pluck('name');
        if ($list_permision)
            return response()->json(['list_permision' => $list_permision, 'all_permission' => $all_permission, 'user' => $user->name] ,200);
        return response()->json(['status_code' => 400, 'message' => 'FAILED'] ,400);
    }

    public function updatePermission(Request $request)
    {
        $param = $request->all();
        $id = $param['role_id'];
        $role = Role::find($id);
        $permission = isset($param['checkBoxs']) ? $param['checkBoxs'] : [];
        $role->syncPermissions($permission);
            return response()->json(['status_code' => 200] ,200);
    }
}
