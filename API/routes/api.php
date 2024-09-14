<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use Laravel\Sanctum\Contracts\HasApiTokens;

Route::post('/api/login', [AuthController::class, 'login'])->name('login');
Route::post ('/login', [AuthController::class, 'login']);
Route::post ('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post ('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/appointments', AppointmentController::class);
    Route::put('/postpone/{id}', [AppointmentController::class, 'postpone']);
    Route::get('/user', function (Request $request) {
        return ['user' => $request->user(), 'token' => $request->user()->tokens];});
});
