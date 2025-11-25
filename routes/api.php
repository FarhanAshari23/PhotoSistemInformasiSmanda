<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//students
Route::post('/upload-image-students', [StudentController::class, 'uploadPhoto']);
Route::post('/update-image-students', [StudentController::class, 'updatePhoto']);
Route::post('/delete-image-student', [StudentController::class, 'deletePhoto']);
Route::post('/delete-multiple-students', [StudentController::class, 'deleteMultiplePhotos']);
//teachers
Route::post('/upload-image-teachers', [TeacherController::class, 'uploadPhoto']);
Route::post('/update-image-teachers', [TeacherController::class, 'updatePhoto']);
Route::post('/delete-image-teachers', [TeacherController::class, 'deletePhoto']);
