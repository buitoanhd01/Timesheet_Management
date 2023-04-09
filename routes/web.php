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
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'status']], function () {
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin-dashboard');
        Route::get('/admin/calendar', [App\Http\Controllers\Admin\CalendarController::class, 'index'])->name('admin-calendar');
    });
    
    Route::group(['middleware' => ['role:employee,admin']], function () {
        Route::get('/', [App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('employee-dashboard');
    });
});
