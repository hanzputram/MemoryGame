<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('start-screen');
})->name('start');

Route::get('/rules', function () {
    return view('rules');
})->name('rules');


Route::get('/landing', [GameController::class, 'landing'])
    ->name('memory.landing');

Route::middleware('auth')->group(function () {
    Route::get('/memory/{level}', [GameController::class, 'index'])->name('memory.index');
    Route::post('/memory/finish', [GameController::class, 'finish'])->name('memory.finish');
});


// tampil form login
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

// proses login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post')
    ->middleware('guest');

// tampil form register
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register')
    ->middleware('guest');

// proses register
Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post')
    ->middleware('guest');

// logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
