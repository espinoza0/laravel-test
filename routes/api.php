<?php

use App\Http\Controllers\AuthControler;
use App\Http\Controllers\PostController;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// tablas: users (hasMany -> posts), posts (hasMany -> comments, belongsTo -> user),
//comments (belongsTo -> user)


//auth
Route::post('register', [AuthControler::class, 'register']);
Route::post('login', [AuthControler::class, 'login']);
Route::get('/public-posts', [PostController::class, 'publicPosts']);

Route::middleware([IsUserAuth::class])->group(function () {
    Route::post('logout', [AuthControler::class, 'logout']);

    // posts
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});
