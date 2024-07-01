<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerEmployeeController;
use App\Http\Controllers\Api\CustomerPaymentPeriodController;
use App\Http\Controllers\Api\CustomerTimesheetController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PaymentPeriodController;
use App\Http\Controllers\Api\PaymentPeriodTimesheetController;
use App\Http\Controllers\Api\PaymentTypeController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TimesheetController;
use App\Http\Controllers\Api\UserController;

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


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class)->only(['index']);

    Route::apiResource('roles', RoleController::class)->only(['index']);

    Route::apiResource('customers', CustomerController::class)->except(['destroy']);
    Route::apiResource('customers.employees', CustomerEmployeeController::class)->only(['index']);
    Route::apiResource('customers.timesheets', CustomerTimesheetController::class)->only(['index']);
    Route::apiResource('customers.payment_periods', CustomerPaymentPeriodController::class)->only(['index']);

    Route::apiResource('payment_types', PaymentTypeController::class)->only(['index']);

    Route::resource('employees', EmployeeController::class);

    Route::apiResource('timesheets', TimesheetController::class);
    Route::post('timesheets/{timesheet}/updateStatus', [TimesheetController::class, 'updateStatus']);
    Route::post('timesheets/{timesheet}/updateAmount', [TimesheetController::class, 'updateAmount']);

    Route::apiResource('payment_periods', PaymentPeriodController::class)->only(['index', 'store', 'show']);
    Route::apiResource('payment_periods.timesheets', PaymentPeriodTimesheetController::class)->only(['index']);
});