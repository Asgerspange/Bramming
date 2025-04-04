<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StudentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('web')->group(function () {
    Route::post('/addComment', [CommentController::class, 'addComment']);
    Route::post('/editComment', [CommentController::class, 'editComment']);
    Route::post('/deleteComment', [CommentController::class, 'deleteComment']);
    Route::post('/student/image', [StudentController::class, 'studentImage']);

    Route::middleware('admin')->group(function () {
        Route::post('/download-visibility', [StudentController::class, 'downloadVisibility']);
        Route::post('/delete-students', [StudentController::class, 'deleteStudents']);
        Route::delete('/admin/delete/{student}', [StudentController::class, 'deleteStudent']);

        Route::post('/admin/make-teacher', [StudentController::class, 'makeTeacher']);
        Route::post('/admin/remove-teacher', [StudentController::class, 'removeTeacher']);
    });
    Route::get('/download-comments/{student}', [StudentController::class, 'downloadComments']);
});
