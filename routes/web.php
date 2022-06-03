<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\videoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/register', [registerController::class, 'index'])->name('register');
Route::post('/register', [registerController::class, 'register'])->name('register');

Route::get('/login', [loginController::class, 'index'])->name('login');
Route::post('/login', [loginController::class, 'login'])->name('login');

Route::get('/logout', [loginController::class, 'logout'])->name('logout');

Route::post('/search', [videoController::class, 'search'])->name('search');
Route::get('/search', [videoController::class, 'find'])->name('search');
