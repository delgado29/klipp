<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WorkingHourController;
use App\Http\Controllers\api\AuthController;

Route::middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::apiResource('businesses', BusinessController::class);
    Route::get('/businesses/{id}/services', [ServiceController::class, 'getByBusiness']);
    Route::get('/businesses/{id}/available-hours', [AppointmentController::class, 'getAvailableHours']);
    // Public appointment routes
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);
    // Protected appointment store route
    Route::post('/appointments', [AppointmentController::class, 'store']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('services', ServiceController::class);
    
    Route::apiResource('schedules', ScheduleController::class);
    Route::apiResource('working-hours', WorkingHourController::class);
});
