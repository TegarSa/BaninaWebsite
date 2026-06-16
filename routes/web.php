<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontProductController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductController as DashProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\BannerController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/product/{slug}', [FrontProductController::class, 'show'])->name('product.show');
Route::get('/catalog/{category?}', [FrontProductController::class, 'index'])->name('catalog');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'proses_login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/products/{id}/toggle-feature', [DashProductController::class, 'toggleFeature'])->name('products.toggle-feature');
    Route::post('/products/{id}/toggle-active', [DashProductController::class, 'toggleActive'])->name('products.toggle-active');
    Route::post('/products/{id}/image/{imgId}/set-primary', [DashProductController::class, 'setPrimaryImage'])->name('products.image.set-primary');
    Route::delete('/products/{id}/image/{imgId}', [DashProductController::class, 'destroyImage'])->name('products.image.destroy');

    Route::post('/categories/{id}/toggle-active', [CategoryController::class, 'toggleActive'])->name('categories.toggle-active');

    Route::post('/banners/{id}/toggle-active', [BannerController::class, 'toggleActive'])->name('banners.toggle-active');
    
    Route::resource('banners', BannerController::class);
    Route::resource('products', DashProductController::class);
    Route::resource('categories', CategoryController::class);
});