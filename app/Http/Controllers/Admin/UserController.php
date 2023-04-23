<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user-management.user-list');
    }

    public function showCreateUserForm(Request $request)
    {
        $data = [];
        $data['role'] = Role::all();
        $data['password_default'] = Setting::getDefaultPassword();
        if (!isset($data['password_default'])) {
            $data['password_default'] = '1234567890';
        }
        return view('admin.user-management.user-create', 
        [
            'roles' => $data['role'],
            'password_default' => $data['password_default']
        ]);
    }

    public function createUser(Request $request)
    {
        $validate = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'role' => ['required', Rule::exists('roles', 'name')],
        ]);
        $user = new User([
            'username' => $request->input('username'),
            'password' => Hash::make(Setting::getDefaultPassword()),
            'status'   => $request->input('status'),
        ]);
        $user->assignRole($request->input('role'));

        $user->save();
        return redirect()->route('admin-user-management')->with('success', 'Thêm tài khoản thành công!');
    }

    public function showEditUserForm(Request $request, $id)
    {
        $data = [];
        $data['role'] = Role::all();
        $user = User::with('roles')->find($id);
        $role = $user->roles[0];
        return view('admin.user-management.user-edit', 
        [
            'roles'             => $data['role'],
            'user'              => $user,
            'role_name'         => $role->name
        ]);
    }

    public function editUser(Request $request, $id)
    {
        $validate = $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'role' => ['required', Rule::exists('roles', 'name')],
        ]);
        if ($id == Auth::user()->id) {
            return back()->with('failed', 'Không thể sửa trạng thái tài khoản của bản thân!');
        }
        $user = User::find($id);
        $user->syncRoles($request->role);
        $user->status = $request->status;

        $user->save();
        return redirect()->route('admin-user-management')->with('success', 'Sửa tài khoản thành công!');
    }
}
