<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PaymentPeriodController;
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

Route::apiResource('users', UserController::class)->only(['index']);

Route::apiResource('roles', RoleController::class)->only(['index']);

Route::apiResource('customers', CustomerController::class)->except(['destroy']);

Route::apiResource('payment-types', PaymentTypeController::class)->only(['index']);

Route::resource('employees', EmployeeController::class);

Route::apiResource('timesheets', TimesheetController::class);

Route::apiResource('payment-periods', PaymentPeriodController::class);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});