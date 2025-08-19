<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\BuyerActionController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerActionController;
use App\Http\Controllers\NumberController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceGenerationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Admin Dashboard - Main functionality on home page
Route::get('/', [AdminController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Admin panel routes
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Buyer management routes
    Route::resource('buyers', BuyerController::class);
    Route::post('/buyer-actions', BuyerActionController::class)->name('buyer.actions');
    
    // Seller management routes
    Route::resource('sellers', SellerController::class);
    Route::post('/seller-actions', SellerActionController::class)->name('seller.actions');
    
    // Number management routes
    Route::resource('numbers', NumberController::class);
    
    // Invoice and billing routes
    Route::resource('invoices', InvoiceController::class);
    Route::post('/invoice-actions', InvoiceGenerationController::class)->name('invoice.actions');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
