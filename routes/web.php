<?php

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

Route::middleware('auth:sanctum')->prefix('user/')->group(function () {
    Route::post('add-post', [\App\Http\Controllers\PostController::class, 'addPost']);
    Route::get('posts', [\App\Http\Controllers\PostController::class, 'getUserPosts']);
});

Route::prefix('auth/')->group(function () {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

Route::get('/posts', [\App\Http\Controllers\PostController::class, 'getPosts']);
Route::get('/categories', [\App\Http\Controllers\PostController::class, 'categories']);

//default web route for SPA
Route::get('/{any?}', [\App\Http\Controllers\HomeController::class, 'index'])
    ->where('any', '.*');
