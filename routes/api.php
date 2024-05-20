<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IndividualInternController;
use App\Http\Controllers\InternsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/individualIntern', IndividualInternController::class)->only('index');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard/interns', [InternsController::class, 'getActiveInterns']);
        Route::apiResource('/attendance', AttendanceController::class);
        Route::apiResource('/individualIntern', IndividualInternController::class)->only('update', 'destroy');
    });
    
    Route::prefix('user')->group(function () {
        Route::apiResource('/attendance', AttendanceController::class);
        Route::apiResource('/application/individualIntern', IndividualInternController::class)->only('store');
    });
});