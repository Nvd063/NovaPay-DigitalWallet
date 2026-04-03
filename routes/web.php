<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VirtualCardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Register Flow
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/verify-otp', [RegisterController::class, 'showOtpVerify'])->name('otp.verify');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp']);

Route::get('/set-mpin', [RegisterController::class, 'showSetMpin'])->name('mpin.set');
Route::post('/set-mpin', [RegisterController::class, 'storeMpin']);



// Login Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::middleware(['auth'])->group(function () {
    Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transfer.process');
    Route::post('/topup', [TransactionController::class, 'topup'])->name('topup.process');

    // History Page (Optional)
    Route::get('/history', [DashboardController::class, 'history'])->name('history');
    Route::get('/profile', [App\Http\Controllers\DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [App\Http\Controllers\DashboardController::class, 'updateProfile'])->name('profile.update');

    Route::get('/manage-cards', [VirtualCardController::class, 'manage'])->name('cards.manage');
    Route::get('/select-card/{id}', [VirtualCardController::class, 'selectCard'])->name('cards.select');
    Route::post('/cards/store', [VirtualCardController::class, 'store'])->name('cards.store');
});

Route::post('/pay-bill', [TransactionController::class, 'payBill'])->name('bill.process');
Route::post('/mobile-load', [TransactionController::class, 'mobileLoad'])->name('load.process');

