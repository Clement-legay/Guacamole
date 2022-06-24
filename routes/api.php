<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\videoController;
use Illuminate\Http\Request;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

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

Route::get('/categories', [CategoryController::class, 'searchCategory'])->name('API_categories');
Route::put('/views/{id}', [ViewController::class, 'update'])->name('API_views');

Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
    Route::get('?page={page}&row={row}', [videoController::class, 'show'])->name('details');
    Route::get('/{video}', [videoController::class, 'show'])->name('details');
});

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/{user}', [UserController::class, 'show'])->name('details');
});

