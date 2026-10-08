<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoanController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// --- AUTH ROUTES ---
Route::middleware('auth')->group(function () {

    // Home Page
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Product Page
    Route::middleware(['can:manage-products'])->group(function () {
        Route::resource('products', ProductController::class);
    });

    Route::get('products/{product}/log', [ProductController::class, 'log'])->name('products.log');

    // Purchases Page
    Route::middleware(['can:manage-purchases'])->group(function () {
        Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    Route::middleware(['can:manage-sales'])->group(function () {
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    Route::middleware(['can:manage-employees'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    Route::get('loans/{loan}/history', [LoanController::class, 'history'])->name('loans.history');
    Route::post('loans/{loan}/pay', [LoanController::class, 'pay'])->name('loans.pay');
    Route::resource('loans', LoanController::class)->except(['edit', 'update']);

    // Super Admin Config
    Route::middleware(['can:manage-users'])->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::middleware(['can:manage-roles'])->group(function () {
        Route::resource('roles', RoleController::class);
    });

    Route::middleware(['can:manage-permissions'])->group(function () {
        Route::resource('permissions', PermissionController::class);
    });

    // Edit Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
