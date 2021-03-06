<?php

use App\Http\Controllers\API\Article\ArticleController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::prefix('/category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{id}/show', [CategoryController::class, 'show']);
        Route::put('/{id}/update', [CategoryController::class, 'update']);
        Route::delete('/{id}/delete', [CategoryController::class, 'destroy']);
    });

    Route::prefix('/article')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::post('/', [ArticleController::class, 'store']);
        Route::get('/{id}/show', [ArticleController::class, 'show']);
        Route::put('/{id}/update', [ArticleController::class, 'update']);
        Route::delete('/{id}/delete', [ArticleController::class, 'destroy']);
    });
});
