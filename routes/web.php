<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('equipment', EquipmentController::class);
    Route::patch('equipment/{equipment}/status', [EquipmentController::class, 'updateStatus'])->name('equipment.status');

    Route::resource('kategori', KategoriController::class);

    Route::resource('booking', BookingController::class)->only(['index', 'show', 'destroy']);
    Route::patch('booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.status');
    Route::get('booking/{booking}/whatsapp', [BookingController::class, 'whatsappCustomer'])->name('booking.whatsapp');
    Route::get('booking/export/csv', [BookingController::class, 'export'])->name('booking.export');

    Route::resource('payment', PaymentController::class)->only(['index', 'show', 'destroy']);
    Route::patch('payment/{payment}/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    Route::patch('payment/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payment.status');
    Route::post('payment/bulk-action', [PaymentController::class, 'bulkAction'])->name('payment.bulk');
    Route::get('payment/export/csv', [PaymentController::class, 'export'])->name('payment.export');
});

require __DIR__.'/auth.php';
