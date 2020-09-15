<?php

use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\UserController;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::post('create', [UserController::class, 'create']);

    Route::post('login', [UserController::class, 'login']);
    Route::post('refresh', [UserController::class, 'refresh']);

    Route::prefix('{obUser}')->group(function () {
        Route::get('', [UserController::class, 'get'])->middleware('auth.check');

        Route::post('delete', [UserController::class, 'delete']);
        Route::post('update', [UserController::class, 'update']);
    });
});

Route::prefix('school')->group(function () {
    Route::middleware(['auth.check'])->group(function () {
        Route::get('', [SchoolController::class, 'index']);

        Route::post('/create', [SchoolController::class, 'create'], 201);

        Route::prefix('{obSchool}')->group(function () {
            Route::get('', [SchoolController::class, 'get']);
            Route::post('/update', [SchoolController::class, 'update']);
            Route::post('/delete', [SchoolController::class, 'delete']);
        });
    });
});
