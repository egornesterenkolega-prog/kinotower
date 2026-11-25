<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    // Только для гостей: форма входа и её обработка
    Route::middleware('guest')->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    });

    // Только для авторизованных пользователей
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // CRUD стран и жанров (экшен show не используется)
        Route::name('admin.')->group(function () {
            Route::resource('countries', CountryController::class)->except(['show']);
            Route::resource('categories', CategoryController::class)->except(['show']);
        });
    });
});
