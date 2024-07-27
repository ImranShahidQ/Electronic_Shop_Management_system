<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\oldAccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('sales/monthly', [SaleController::class, 'monthly'])->name('sales.monthly');
    Route::get('sales/monthly/{year}/{month}/details', [SaleController::class, 'getMonthlyDetails'])->name('sales.monthly.details');
    Route::get('purchases/monthly', [PurchaseController::class, 'monthly'])->name('purchases.monthly');
    Route::get('purchases/monthly/{year}/{month}/details', [PurchaseController::class, 'getMonthlyDetails'])->name('purchases.monthly.details');
    Route::get('expenses/monthly', [ExpenseController::class, 'monthly'])->name('expenses.monthly');
    Route::get('expenses/monthly/{year}/{month}/details', [ExpenseController::class, 'getMonthlyDetails'])->name('expenses.monthly.details');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('oldAccounts', oldAccountController::class);
});

require __DIR__.'/auth.php';
