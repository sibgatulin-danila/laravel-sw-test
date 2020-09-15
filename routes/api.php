<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\SchoolClassController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\StudentController;
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
    Route::get('', [SchoolController::class, 'index']);

    Route::post('create', [SchoolController::class, 'create'], 201);

    Route::prefix('{obSchool}')->group(function () {
        Route::get('', [SchoolController::class, 'get']);

        Route::post('update', [SchoolController::class, 'update']);
        Route::post('delete', [SchoolController::class, 'delete']);
    });
});

Route::prefix('employee')->group(function () {
    Route::get('', [EmployeeController::class, 'index']);

    Route::post('create', [EmployeeController::class, 'create']);

    Route::prefix('{obUser}')->group(function () {
        Route::get('', [EmployeeController::class, 'get']);

        Route::post('update', [EmployeeController::class, 'update']);
        Route::post('delete', [EmployeeController::class, 'delete']);
    });
});

Route::prefix('student')->group(function () {
    Route::get('', [StudentController::class, 'index']);

    Route::post('create', [StudentController::class, 'create']);

    Route::prefix('{obUser}')->group(function () {
        Route::get('', [StudentController::class, 'get']);

        Route::post('update', [StudentController::class, 'update']);
        Route::post('delete', [StudentController::class, 'delete']);
    });
});

Route::prefix('class')->group(function () {
    Route::get('', [SchoolClassController::class, 'index']);

    Route::post('create', [SchoolClassController::class, 'create']);

    Route::prefix('{obSchoolClass}')->group(function () {
        Route::get('', [SchoolClassController::class, 'get']);

        Route::post('update', [SchoolClassController::class, 'update']);
        Route::post('delete', [SchoolClassController::class, 'delete']);
    });
});

Route::prefix('timetable')->group(function () {
    Route::get('', [TimetableController::class, 'index']);

    Route::post('create', [TimetableController::class, 'create']);

    Route::prefix('{obTimetable}')->group(function () {
        Route::get('', [TimetableController::class, 'get']);

        Route::post('update', [TimetableController::class, 'update']);
        Route::post('delete', [TimetableController::class, 'delete']);
    });
});

Route::prefix('grade')->group(function () {
    Route::get('', [GradeController::class, 'index']);

    Route::post('create', [GradeController::class, 'create']);

    Route::prefix('{obGrade}')->group(function () {
        Route::get('', [GradeController::class, 'get']);

        Route::post('update', [GradeController::class, 'update']);
        Route::post('delete', [GradeController::class, 'delete']);
    });
});
