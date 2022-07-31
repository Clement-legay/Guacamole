<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
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

// check app_env to change the route domain
Route::group(['middleware' => 'auth'], function () {
    Route::get('/liked', [VideoController::class, 'liked'])->name('likedVideos');
    Route::get('/history', [VideoController::class, 'history'])->name('history');

    Route::get('/subscribe/{user}', [SubscribeController::class, 'subscribe'])->name('subscribe');
    Route::get('/unsubscribe/{user}', [SubscribeController::class, 'unsubscribe'])->name('unsubscribe');

    Route::get('/like/{video}', [LikeController::class, 'like'])->name('like');
    Route::get('/dislike/{video}', [LikeController::class, 'dislike'])->name('dislike');
    Route::get('/deleteOpinion/{video}', [LikeController::class, 'deleteOpinion'])->name('deleteOpinion');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/content', [UserController::class, 'content'])->name('content');
        Route::get('/upload', [UserController::class, 'upload'])->name('upload');
        Route::get('/upload/success', [UserController::class, 'uploadSuccess'])->name('uploadSuccess');
        Route::get('/upload/{video}', [UserController::class, 'draftEdit'])->name('draftEdit');
        Route::put('/edit/{video}', [videoController::class, 'draftUpdate'])->name('draftUpdate');


        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/comments', [UserController::class, 'comments'])->name('comments');
        Route::get('/parameters', [UserController::class, 'profile'])->name('parameters');

        Route::get('/account', [UserController::class, 'profile'])->name('account');
        Route::put('/account/{user}', [UserController::class, 'update'])->name('update');
        Route::get('/account/{user}/avatar/delete', [UserController::class, 'deleteAvatar'])->name('updateAvatarDelete');
        Route::get('/account/{user}/banner/delete', [UserController::class, 'deleteBanner'])->name('updateBannerDelete');
    });

    Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
        Route::get('/create', [VideoController::class, 'create'])->name('create');
        Route::post('/upload', [VideoController::class, 'upload'])->name('upload');

        Route::group(['middleware' => 'own'], function () {
            Route::get('/{video}', [VideoController::class, 'show'])->name('details');
            Route::get('/{video}/dashboard', [VideoController::class, 'dashboard'])->name('dashboard');
            Route::get('/{video}/comments', [VideoController::class, 'comments'])->name('comments');
        });

        Route::put('/{video}/update', [VideoController::class, 'update'])->name('update');
        Route::get('/{video}/delete', [VideoController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {
        Route::post('/create', [CommentController::class, 'create'])->name('create');
        Route::delete('/{comment}', [CommentController::class, 'delete'])->name('delete');
        Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::redirect('/', '/admin/videos', 301);

        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::delete('/users/delete', [UserController::class, 'adminDeleteMany'])->name('users.delete');
        Route::get('/users/{user}', [AdminController::class, 'user'])->name('user.select');
        Route::put('/users/{user}/update', [UserController::class, 'adminUpdate'])->name('user.update');
        Route::get('/users/{user}/delete', [UserController::class, 'adminDelete'])->name('user.delete');

        Route::get('/videos', [AdminController::class, 'videos'])->name('videos');
        Route::get('/videos/{video}', [AdminController::class, 'video'])->name('video');
        Route::put('/videos/{video}/update', [VideoController::class, 'adminUpdate'])->name('video.update');
        Route::get('/videos/{video}/delete', [VideoController::class, 'adminDelete'])->name('video.delete');

        Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
        Route::get('/comments/{comment}', [AdminController::class, 'comment'])->name('comment');
        Route::put('/comments/{comment}/update', [CommentController::class, 'adminUpdate'])->name('comment.update');
        Route::get('/comments/{comment}/delete', [CommentController::class, 'adminDelete'])->name('comment.delete');

        Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
        Route::get('/roles/create', [AdminController::class, 'roles'])->name('role.create');
        Route::post('/roles/create', [RoleController::class, 'create'])->name('role.create');
        Route::get('/roles/{role}', [AdminController::class, 'role'])->name('role.select');
        Route::put('/roles/{role}/update', [RoleController::class, 'update'])->name('role.update');
        Route::get('/roles/{role}/delete', [RoleController::class, 'delete'])->name('role.delete');

        Route::get('/token', [AdminController::class, 'token'])->name('token');
        Route::get('/token/generate', [AdminController::class, 'tokenGenerate'])->name('token.generate');
        Route::post('/token/generate', [AdminController::class, 'tokenGeneration'])->name('token.generate');
        Route::get('/token/delete', [AdminController::class, 'tokenDelete'])->name('token.delete');
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
Route::get('/explore', [PageController::class, 'index'])->name('explore');

Route::get('/search', [videoController::class, 'search'])->name('search');

Route::get('/hashtag/{tag}', [videoController::class, 'hashtag'])->name('hashtag');

Route::get('/channel/{user}', [UserController::class, 'other'])->name('channel');

Route::get('/watch/{video}', [videoController::class, 'watch'])->name('watch');

