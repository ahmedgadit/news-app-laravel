<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/articles', [ArticleController::class, 'index']);

    Route::get('/categories', [CategoryController::class, 'index']);

    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('/sources', [SourceController::class, 'index']);

    Route::post('/sources', [SourceController::class, 'store']);
    
});






