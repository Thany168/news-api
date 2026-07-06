<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\AdminUserController;

use Illuminate\Support\Facades\Route;

//Articles
Route::get('/articles/published',   [ArticleController::class, 'published']);
Route::get('/articles/slug/{slug}', [ArticleController::class, 'bySlug']);
Route::apiResource('articles', ArticleController::class);
// Media Image 
Route::get('/media',           [MediaController::class, 'index']);
Route::post('/media/upload',   [MediaController::class, 'upload']);
Route::delete('/media/{media}', [MediaController::class, 'destroy']);

// Authentication 
Route::post('/auth/login',               [AdminUserController::class, 'login']);
Route::get('/admin-users',               [AdminUserController::class, 'index']);
Route::post('/admin-users',              [AdminUserController::class, 'store']);
Route::delete('/admin-users/{adminUser}', [AdminUserController::class, 'destroy']);
Route::patch('/admin-users/{adminUser}', [AdminUserController::class, 'resetPassword']);
