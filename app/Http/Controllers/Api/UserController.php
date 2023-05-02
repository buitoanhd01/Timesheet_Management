<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function getListUsers(Request $request)
    {
        $param = $request->all();
        $filter = isset($param['filter']) ? $param['filter'] : null;
        $listUser = User::getAllUsersActive($filter);
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

    public function changePassword(Request $request)
    {
        // Kiểm tra xác thực người dùng
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // Kiểm tra mật khẩu hiện tại của người dùng
        if (!Hash::check($request->currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => ['The current password is incorrect.'],
            ]);
        }

        // Kiểm tra mật khẩu mới và xác nhận mật khẩu
        if ($request->newPassword !== $request->confirmPassword) {
            throw ValidationException::withMessages([
                'newPassword' => ['The new password and confirm password do not match.'],
            ]);
        }

        // Lưu trữ mật khẩu mới
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['success' => true]);
    }
}
