<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

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
