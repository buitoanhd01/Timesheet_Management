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

Route::post('/update_list_calendar', [App\Http\Controllers\Api\CalendarController::class, 'insertAttendance'])
->name('update_list_calendar');

Route::get('/get_self_check_status', [App\Http\Controllers\Api\CalendarController::class, 'getSelfAttendanceNow'])
->name('get_self_check_status');