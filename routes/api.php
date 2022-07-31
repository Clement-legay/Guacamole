<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SubscribeController;
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
Route::get('/frame/{video}/get', [videoController::class, 'getFrame'])->name('API_frame_get');
Route::post('{user}/video/upload', [videoController::class, 'uploadVideoFile'])->name('API_upload_video_file');
Route::get('{video}/progress', [videoController::class, 'getVideoProgress'])->name('API_process_progress');


Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

    Route::post('/{user}/profile_picture/update', [UserController::class, 'updateAvatar'])->name('API_user_update_avatar');
    Route::post('/{user}/subscribe/{channel}', [SubscribeController::class, 'sendSubscribe'])->name('API_subscribe');
    Route::delete('/{user}/unsubscribe/{channel}', [SubscribeController::class, 'sendUnsubscribe'])->name('API_unsubscribe');
    Route::delete('/{user}/deleteOpinion/{video}', [LikeController::class, 'deleteOpinion'])->name('API_deleteOpinion');
    Route::post('/{user}/comment/{video}', [CommentController::class, 'commentAPI'])->name('API_comment');
    Route::post('/{user}/reply/{comment}', [CommentController::class, 'replyAPI'])->name('API_reply');
    Route::delete('/{user}/deleteComment/{comment}', [CommentController::class, 'deleteAPI'])->name('API_deleteComment');
    Route::post('{user}/video/upload', [videoController::class, 'uploadVideoAPI'])->name('API_upload_video');
    Route::post('{user}/video/{video}/edit', [videoController::class, 'editVideoAPI'])->name('API_upload_video');
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('/register', [registerController::class, 'registerAPI'])->name('API_register');
    Route::post('/login', [loginController::class, 'loginAPI'])->name('API_login');
});


Route::group(['middleware' => 'authorization'], function () {
    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/all', [CategoryController::class, 'getCategories'])->name('API_categories');
        Route::get('/{category}', [CategoryController::class, 'getCategory'])->name('API_category');
    });

    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function () {
        Route::get('/{comment}/get', [CommentController::class, 'getComment'])->name('API_comment');
        Route::get('/{comment}/replies', [CommentController::class, 'getReplies'])->name('API_replies');
    });


    Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
        Route::get('/all', [videoController::class, 'getVideos'])->name('API_videos');
        Route::get('/{video}/stats', [videoController::class, 'getVideoStats'])->name('API_video_stats');
        Route::get('/{video}/comments', [videoController::class, 'getVideoComments'])->name('API_video_comments');
        Route::get('/{video}/get', [videoController::class, 'getVideo'])->name('API_video');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/{user}/get', [UserController::class, 'getUser'])->name('API_user');
        Route::get('/{user}/subscribers', [UserController::class, 'getUserSubscribers'])->name('API_user_subscribers');
        Route::get('/{user}/subscriptions', [UserController::class, 'getUserSubscriptions'])->name('API_user_subscriptions');
        Route::get('/{user}/view/{video}', [UserController::class, 'getUserHasView'])->name('API_user_has_view');
        Route::get('/{user}/history', [UserController::class, 'getUserHistory'])->name('API_user_history');


        Route::get('/{user}/like/{video}', [LikeController::class, 'like'])->name('API_like');
        Route::get('/{user}/dislike/{video}', [LikeController::class, 'dislike'])->name('API_dislike');


    });

});


