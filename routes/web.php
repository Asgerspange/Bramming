<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    StudentController,
    RouteController
};
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [StudentController::class, 'register']);

Route::post('/login', [StudentController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/student/{unilogin}', [RouteController::class, 'student']);
    Route::get('/students', [RouteController::class, 'students']);
    Route::get('/profile', [RouteController::class, 'profile'])->name('profile');

    Route::get('/admin', [RouteController::class, 'admin'])->middleware('admin')->name('admin');
});