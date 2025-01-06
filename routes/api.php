<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Check;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Category
Route::get('/category', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::get('/category/{category}', [CategoryController::class, 'show'])->middleware('auth:sanctum');
Route::middleware(['App\Http\Middleware\Check:admin,moderator', 'auth:sanctum'])->group(function () {
    Route::post('/category', [CategoryController::class, 'store']);
    Route::put('/category/{category}', [CategoryController::class, 'update']);
    Route::delete('/category/{category}', [CategoryController::class, 'delete']);
});

// Product
Route::middleware(['App\Http\Middleware\Check:admin', 'auth:sanctum'])->group(function () {
    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/product/{product}', [ProductController::class, 'show']);
    Route::put('/product/{product}', [ProductController::class, 'update']);
    Route::delete('/product/{product}', [ProductController::class, 'delete']);
});

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify', [AuthController::class, 'verify']);

// Profile
Route::post('profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');

// Password
Route::post('password', [AuthController::class, 'password']);

// Post
Route::get('/post', [PostController::class, 'index']);
Route::post('/post', [PostController::class, 'store']);
Route::get('/post/{post}', [PostController::class, 'show']);
Route::put('/post/{post}', [PostController::class, 'update']);
Route::delete('/post/{post}', [PostController::class, 'delete']);

// Task
Route::get('/task', [TaskController::class, 'index'])->middleware('auth:sanctum');
Route::post('/task', [TaskController::class, 'store'])->middleware(['App\Http\Middleware\Check:user', 'auth:sanctum']);

// Comment
Route::post('/comment', [CommentController::class, 'store'])->middleware(['App\Http\Middleware\Check:admin', 'auth:sanctum']);