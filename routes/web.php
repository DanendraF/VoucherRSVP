<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\VoucherScanController;
use App\Http\Controllers\VoucherRedeemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini route utama aplikasi, termasuk RSVP tamu dan
| halaman scanner untuk staf merchandise.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// =========================
// ROUTE RSVP (PUBLIC)
// =========================
Route::get('/rsvp', [RsvpController::class, 'index'])->name('rsvp.index');
Route::post('/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');

// =========================
// ROUTE DASHBOARD (LOGIN)
// =========================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =========================
// ROUTE SCANNER & REDEEM (LOGIN STAF)
// =========================
Route::middleware('auth')->group(function () {

    // Halaman scanner QR
    Route::get('/admin/voucher/scan',
        [VoucherScanController::class, 'index']
    )->name('voucher.scan');

    // API redeem voucher
    Route::post('/voucher/redeem',
        [VoucherRedeemController::class, 'redeem']
    )->name('voucher.redeem');

    // Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================
// AUTH ROUTES BAWAAAN BREEZE
// =========================
require __DIR__.'/auth.php';
