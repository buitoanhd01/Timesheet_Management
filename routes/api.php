<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/get_list_calendar', [App\Http\Controllers\Api\CalendarController::class, 'index'])
->name('get_list_calendar');

Route::get('/get_self_calendar', [App\Http\Controllers\Api\CalendarController::class, 'getAttendanceByEmployeeID'])
->name('get_self_calendar');

Route::post('/update_list_calendar', [App\Http\Controllers\Api\CalendarController::class, 'insertAttendance'])
->name('update_list_calendar');

Route::get('/get_self_check_status', [App\Http\Controllers\Api\CalendarController::class, 'getSelfAttendanceNow'])
->name('get_self_check_status');

Route::get('/get_user_list', [App\Http\Controllers\Api\UserController::class, 'getListUsers'])
->name('get_user_list');

Route::post('/delete_user', [App\Http\Controllers\Api\UserController::class, 'deleteUser'])
->name('delete_user');

Route::get('/get_employee_list', [App\Http\Controllers\Api\EmployeeController::class, 'getListEmployees'])
->name('get_employee_list');

Route::get('/get_role_list', [App\Http\Controllers\Api\RoleController::class, 'getListRoles'])
->name('get_role_list');

Route::get('/get_role_list_by_id', [App\Http\Controllers\Api\RoleController::class, 'getListPermisionByRoleID'])
->name('get_role_list_by_id');

Route::get('/get_role_list_by_user', [App\Http\Controllers\Api\RoleController::class, 'getListPermisionByUserID'])
->name('get_role_list_by_user');

Route::get('/update_permission', [App\Http\Controllers\Api\RoleController::class, 'updatePermission'])
->name('update_permission');

Route::post('/add_role', [App\Http\Controllers\Api\RoleController::class, 'addRole'])
->name('add_role');

Route::get('/delete_role', [App\Http\Controllers\Api\RoleController::class, 'deleteRole'])
->name('delete_role');

Route::get('/get_department_list', [App\Http\Controllers\Api\DepartmentController::class, 'getListDepartments'])
->name('get_department_list');

Route::post('/delete_employee', [App\Http\Controllers\Api\EmployeeController::class, 'deleteEmployee'])
->name('delete_employee');

Route::get('/get_self_request', [App\Http\Controllers\Api\RequestController::class, 'getSelfRequest'])
->name('get_self_request');

Route::get('/get_all_request', [App\Http\Controllers\Api\RequestController::class, 'getAllRequest'])
->name('get_all_request');

Route::post('/add_new_request', [App\Http\Controllers\Api\RequestController::class, 'createNewRequest'])
->name('add_new_request');

Route::get('/get_dashboard_calendar', [App\Http\Controllers\Api\CalendarController::class, 'getDashboardCalendar'])
->name('get_dashboard_calendar');

Route::post('/change-password', [App\Http\Controllers\Api\UserController::class, 'changePassword'])
->name('change-password');

Route::get('/get_report_attendances', [App\Http\Controllers\Api\ReportController::class, 'getReportAttendance'])
->name('get_report_attendances');

Route::post('/update_status_request', [App\Http\Controllers\Api\RequestController::class, 'updateStatusRequest'])
->name('update_status_request');

Route::post('/delete_department', [App\Http\Controllers\Api\DepartmentController::class, 'deleteDepartment'])
->name('delete_department');

Route::post('/delete_position', [App\Http\Controllers\Api\PositionController::class, 'deletePosition'])
->name('delete_position');

Route::get('/get_position_list', [App\Http\Controllers\Api\PositionController::class, 'getListPositions'])
->name('get_position_list');

Route::get('/get_employee_list_no_account', [App\Http\Controllers\Api\EmployeeController::class, 'getListEmployeesNoAccount'])
->name('get_employee_list_no_account');

Route::get('/assign_user', [App\Http\Controllers\Api\EmployeeController::class, 'assignUser'])
->name('assign_user');