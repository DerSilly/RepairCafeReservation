<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use Laravel\Sanctum\Contracts\HasApiTokens;


Route::post ('/login', [AuthController::class, 'login']);
Route::post ('/register', [AuthController::class, 'register']);
Route::get('/user', function (Request $request) {
    return ['user' => $request->user(), 'token' => $request->user()->tokens];
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get ('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/appointments', AppointmentController::class);
});
