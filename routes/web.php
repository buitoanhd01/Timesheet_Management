<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'status']], function () {
    Route::group(['middleware' => ['permission:using']], function () {
        Route::get('/request', [App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('employee-request');

        Route::get('/calendar', [App\Http\Controllers\Admin\CalendarController::class, 'getSelfAttendance'])->name('my-attendance');
        
    });
    Route::group(['middleware' => ['role:employee']], function () {
        //
        Route::get('/employee', [App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('employee-dashboard');
    });
    Route::group(['middleware' => ['permission:manage-general']], function () {
        //Dashboard
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin-dashboard');

        //Timesheet
        Route::get('/admin/calendar', [App\Http\Controllers\Admin\CalendarController::class, 'index'])->name('admin-calendar');

        //Employee
        Route::get('/admin/employee', [App\Http\Controllers\Admin\EmployeeController::class, 'index'])->name('admin-employee');
        Route::get('/admin/employee/create', [App\Http\Controllers\Admin\EmployeeController::class, 'showCreateEmployeeForm'])->name('admin-employee-create-show');
        Route::post('/admin/employee/create', [App\Http\Controllers\Admin\EmployeeController::class, 'createEmployee'])->name('admin-employee-create');
        Route::get('/admin/employee/edit/{id}', [App\Http\Controllers\Admin\EmployeeController::class, 'showEditEmployeeForm'])->name('admin-employee-edit-show');
        Route::put('/admin/employee/edit/{id}', [App\Http\Controllers\Admin\EmployeeController::class, 'editEmployee'])->name('admin-employee-edit');

        //User
        Route::get('/admin/user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin-user-management');
        Route::get('/admin/user/create', [App\Http\Controllers\Admin\UserController::class, 'showCreateUserForm'])->name('admin-user-show-create');
        Route::post('/admin/user/create', [App\Http\Controllers\Admin\UserController::class, 'createUser'])->name('admin-user-create');
        Route::get('/admin/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'showEditUserForm'])->name('admin-user-edit-show');
        Route::put('/admin/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('admin-user-edit');

        //Department
        Route::get('/admin/department', [App\Http\Controllers\Admin\DepartmentController::class, 'index'])->name('admin-department-management');
        Route::get('/admin/department/create', [App\Http\Controllers\Admin\DepartmentController::class, 'showCreateDepartmentForm'])->name('admin-department-show-create');
        Route::post('/admin/department/create', [App\Http\Controllers\Admin\DepartmentController::class, 'addNewDepartment'])->name('admin-department-create');
        // Route::post('/admin/department/create', [App\Http\Controllers\Admin\DepartmentController::class, 'createUser'])->name('admin-user-create');

        //Role
        Route::get('/admin/role', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin-role-management');

        //Position
        Route::get('/admin/position', [App\Http\Controllers\Admin\PositionController::class, 'index'])->name('admin-position-management');
        Route::get('/admin/position/create', [App\Http\Controllers\Admin\PositionController::class, 'showCreatePositionForm'])->name('admin-position-show-create');
        Route::post('/admin/position/create', [App\Http\Controllers\Admin\PositionController::class, 'addNewPosition'])->name('admin-position-create');
    });
    
    // Route::group(['middleware' => ['role:manage-users']], function () {
    //     Route::get('/', [App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('employee-dashboard');
    // });
});