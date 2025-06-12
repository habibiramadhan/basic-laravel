<?php
// routes/web.php - replace yang ada dengan ini

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{id}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('booking', CustomerBookingController::class)->only(['index', 'store', 'show']);
    Route::get('booking/{booking}/payment', [CustomerBookingController::class, 'payment'])->name('booking.payment');
    
    Route::post('payment/upload', [CustomerPaymentController::class, 'uploadTransfer'])->name('payment.upload');
    Route::post('payment/whatsapp', [CustomerPaymentController::class, 'whatsappConfirm'])->name('payment.whatsapp');
});

// Admin Routes
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