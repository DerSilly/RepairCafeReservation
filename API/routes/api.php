<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use Laravel\Sanctum\Contracts\HasApiTokens;
use App\Http\Controllers\AIController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RepairsController;

Route::post('/api/login', [AuthController::class, 'login'])->name('login');
Route::post ('/login', [AuthController::class, 'login']);
Route::post ('/register', [AuthController::class, 'register']);
Route::get ('/nicknames', [AIController::class, 'nicknames']);
Route::post ('/errorlist', [AIController::class, 'errorList']);
Route::get ('/repairs', [RepairsController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post ('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/appointments', AppointmentController::class);
    Route::apiResource('/locations', LocationController::class);
    Route::put('/postpone/{id}', [AppointmentController::class, 'postpone']);
    Route::get('/user', function (Request $request) {
        return ['user' => $request->user(), 'token' => $request->user()->tokens];});
});
