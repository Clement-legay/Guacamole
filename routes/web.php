<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
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
Route::group(['domain' => ((env('APP_ENV') == 'production') ? 'www.guacatube.fr' : null)], function() {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/subscribe/{user}', [SubscribeController::class, 'subscribe'])->name('subscribe');
        Route::get('/unsubscribe/{user}', [SubscribeController::class, 'unsubscribe'])->name('unsubscribe');

        Route::get('/like/{video}', [LikeController::class, 'like'])->name('like');
        Route::get('/dislike/{video}', [LikeController::class, 'dislike'])->name('dislike');
        Route::get('/deleteOpinion/{video}', [LikeController::class, 'deleteOpinion'])->name('deleteOpinion');

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/content', [UserController::class, 'profile'])->name('content');

            Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
            Route::get('/comments', [UserController::class, 'comments'])->name('comments');
            Route::get('/parameters', [UserController::class, 'profile'])->name('parameters');

            Route::get('/account', [UserController::class, 'profile'])->name('account');
            Route::put('/account/{user}', [UserController::class, 'update'])->name('update');

            Route::get('/video/{video}', [VideoController::class, 'update'])->name('videoUpdate');
            Route::put('/video/{video}', [VideoController::class, 'updateIt'])->name('update');
            Route::delete('/video/{video}', [VideoController::class, 'delete'])->name('videoDelete');

        });

        Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
            Route::get('/create', [VideoController::class, 'create'])->name('create');
            Route::post('/upload', [VideoController::class, 'upload'])->name('upload');

            Route::get('/{video}', [VideoController::class, 'show'])->name('details');
            Route::get('/{video}/dashboard', [VideoController::class, 'dashboard'])->name('dashboard');
            Route::get('/{video}/comments', [VideoController::class, 'comments'])->name('comments');

            Route::put('/{video}/update', [VideoController::class, 'update'])->name('update');
            Route::delete('/{video}/delete', [VideoController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {
            Route::post('/create', [CommentController::class, 'create'])->name('create');
            Route::delete('/{comment}', [CommentController::class, 'delete'])->name('delete');
            Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
        });


    });

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [registerController::class, 'index'])->name('register');
        Route::post('/register', [registerController::class, 'register'])->name('register');

        Route::get('/login', [loginController::class, 'index'])->name('login');
        Route::post('/login', [loginController::class, 'login'])->name('login');


        Route::get('/verify/{token}', [UserController::class, 'verify'])->name('verify');
        Route::get('/verification/{token}', [UserController::class, 'verification'])->name('verification');
        Route::get('/resend/{user}', [UserController::class, 'resend'])->name('resend');
    });

    Route::get('/logout', [loginController::class, 'logout'])->name('logout');

    Route::get('/', [PageController::class, 'index'])->name('home');

    Route::post('/search', [videoController::class, 'search'])->name('search');
    Route::get('/search', [videoController::class, 'find'])->name('search');

    Route::get('/hashtag/{tag}', [videoController::class, 'hashtag'])->name('hashtag');

    Route::get('/channel/{user}', [UserController::class, 'other'])->name('channel');

    Route::get('/watch/{video}', [videoController::class, 'watch'])->name('watch');
});

