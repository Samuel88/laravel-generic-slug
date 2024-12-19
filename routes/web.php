<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckSlugType;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pages/{page:slug}', [PageController::class, 'show']);
Route::get('/products/{product:slug}', [ProductController::class, 'show']);
Route::get('/categories/{category:slug}', [CategoryController::class,'show']);

Route::get('{slug}', function () {
    // Rotta gestita dal middleware
})->middleware(CheckSlugType::class);