<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\MediaController;

use Illuminate\Support\Facades\Route;

Route::get('/articles/published',   [ArticleController::class, 'published']);
Route::get('/articles/slug/{slug}', [ArticleController::class, 'bySlug']);
Route::apiResource('articles', ArticleController::class);
// Media Image 
Route::get('/media',           [MediaController::class, 'index']);
Route::post('/media/upload',   [MediaController::class, 'upload']);
Route::delete('/media/{media}', [MediaController::class, 'destroy']);
