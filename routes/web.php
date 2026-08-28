<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/sidecars', [FrontendController::class, 'sidecars'])->name('sidecars.index');
Route::get('/sidecars/{sidecar}', [FrontendController::class, 'sidecarShow'])->name('sidecars.show');
Route::get('/materials', [FrontendController::class, 'materials'])->name('materials');
Route::get('/accessories', [FrontendController::class, 'accessories'])->name('accessories');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'contactSubmit']);

Route::get('/customize', [CustomizationController::class, 'customize'])->name('customize');

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => redirect()->to('/admin/login'))->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/customize', [CustomizationController::class, 'store'])->name('customize.store');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/requests', [DashboardController::class, 'requests'])->name('requests.index');
    Route::get('/requests/{request}', [DashboardController::class, 'requestShow'])->name('requests.show');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
});
