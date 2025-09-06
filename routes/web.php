<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EquipmentController as AdminEquipmentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Equipment routes
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/take', [EquipmentController::class, 'take'])->name('equipment.take');
    Route::get('/equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');
    
    // Rental routes
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::post('/rentals/{rental}/return', [RentalController::class, 'return'])->name('rentals.return');
    Route::get('/rentals/active', [RentalController::class, 'active'])->name('rentals.active');
    Route::get('/rentals/history', [RentalController::class, 'history'])->name('rentals.history');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Equipment management
    Route::resource('equipment', AdminEquipmentController::class)->except(['show']);
    
    // User management
    Route::resource('users', AdminUserController::class)->except(['show']);
    
    // Location management
    Route::resource('locations', AdminLocationController::class)->except(['show']);
});

require __DIR__.'/auth.php';
