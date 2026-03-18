<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/games',          [\App\Http\Controllers\GameController::class, 'index'])->name('games.index');
Route::get('/games/{game:slug}', [\App\Http\Controllers\GameController::class, 'show'])->name('games.show');
Route::get('/games/{game}/quick', [\App\Http\Controllers\GameController::class, 'quickView'])->name('games.quick');
Route::get('/games/{game}/add',          [\App\Http\Controllers\GameController::class, 'addToCart'])->name('games.addToCart');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',     [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',        [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/checkout',      [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout',     [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::post('/games/{game}/reviews',      [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/games/{game}/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/games/{game}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

// Корзина
Route::middleware('web')->group(function () {
    Route::get('/cart',          [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/add/{game}',    [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{game}',       [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{game}',      [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart',             [CartController::class, 'clear'])->name('cart.clear');
    // AJAX для обновления счётчика в хедере
    Route::get('/cart/count',          [CartController::class, 'count'])->name('cart.count');
});

// Публичный логин админа (без middleware)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// Защищённая админ-группа
Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin.auth')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Игры — явно указываем namespace
        Route::resource('games', \App\Http\Controllers\Admin\GameController::class)->except(['show']);
        // Пользователи
        Route::resource('users', UserController::class)
            ->except(['show', 'create', 'store']);

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
