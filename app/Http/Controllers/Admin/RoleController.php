<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $permissionList = Permission::all();
        return view('admin.role.role-management',['permission_list' => $permissionList]);
    }
}
