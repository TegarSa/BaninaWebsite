<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontProductController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductController as DashProductController;

Route::name('home')->get('/', [HomeController::class, 'index']);
Route::name('about')->get('/about', [HomeController::class, 'about']);
Route::name('contact')->get('/contact', [HomeController::class, 'contact']);

Route::controller(FrontProductController::class)->group(function () {
    Route::name('catalog')->get('/catalog/{category?}', 'index');
    Route::name('product.show')->get('/product/{slug}', 'show');
});

Route::controller(AuthController::class)->group(function () {
    Route::name('login')->get('/login', 'index');
    Route::name('login.proses')->post('/login', 'proses_login');
    Route::name('logout')->post('/logout', 'logout');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::name('dashboard')->get('/dashboard', [DashboardController::class, 'index']);
    
    Route::controller(DashProductController::class)->prefix('products')->name('products.')->group(function () {
        Route::name('toggle-feature')->post('/{id}/toggle-feature', 'toggleFeature');
        Route::name('toggle-active')->post('/{id}/toggle-active', 'toggleActive');
        Route::name('image.set-primary')->post('/{id}/image/{imgId}/set-primary', 'setPrimaryImage');
        Route::name('image.destroy')->delete('/{id}/image/{imgId}', 'destroyImage');
    });

    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::name('toggle-active')->post('/{id}/toggle-active', 'toggleActive');
    });

    Route::controller(BannerController::class)->prefix('banners')->name('banners.')->group(function () {
        Route::name('toggle-active')->post('/{id}/toggle-active', 'toggleActive');
    });

    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::name('index')->get('/', 'index');
        Route::name('update')->put('/', 'update');
    });
    
    Route::resources([
        'banners'    => BannerController::class,
        'products'   => DashProductController::class,
        'categories' => CategoryController::class,
    ]);
});