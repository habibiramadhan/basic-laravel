<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
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

    Route::resource('customer', CustomerController::class)->only(['index', 'show']);
    Route::get('customer/{customer}/whatsapp', [CustomerController::class, 'whatsapp'])->name('customer.whatsapp');

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::post('/booking', [ReportController::class, 'bookingReport'])->name('booking');
        Route::post('/equipment', [ReportController::class, 'equipmentReport'])->name('equipment');
        Route::post('/payment', [ReportController::class, 'paymentReport'])->name('payment');
        Route::post('/customer', [ReportController::class, 'customerReport'])->name('customer');
    });

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
