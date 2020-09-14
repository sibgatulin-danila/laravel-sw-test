<?php

use App\Http\Controllers\Api\UserController;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::post('create', [UserController::class, 'create']);

    Route::prefix('{obUser}')->group(function () {
        Route::get('', [UserController::class, 'get']);

        Route::post('delete', [UserController::class, 'delete']);
        Route::post('update', [UserController::class, 'update']);
    });

    // Route::post('/login', [UserController::class, 'login']);
});
