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

Route::get('/get_dashboard_calendar', [App\Http\Controllers\Api\CalendarController::class, 'getDashboardCalendar'])
->name('get_dashboard_calendar');

Route::post('/change-password', [App\Http\Controllers\Api\UserController::class, 'changePassword'])
->name('change-password');

Route::get('/get_report_attendances', [App\Http\Controllers\Api\ReportController::class, 'getReportAttendance'])
->name('get_report_attendances');