<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [RoomController::class, 'index'])->name('home');
Route::get('/rooms', [RoomController::class, 'rooms'])->name('rooms');
Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('room.detail');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Protected routes (must be logged in)
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{id}', [BookingController::class, 'index'])->name('booking');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/dashboard', function() {
    if(auth()->user()->role == 'admin') {
        return redirect()->route('admin');
    }
    return app(App\Http\Controllers\BookingController::class)->dashboard();
})->name('dashboard');

    // Settings
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/rooms/create', [AdminController::class, 'createRoom'])->name('admin.room.create');
    Route::post('/rooms/create', [AdminController::class, 'storeRoom'])->name('admin.room.store');
    Route::get('/rooms/edit/{id}', [AdminController::class, 'editRoom'])->name('admin.room.edit');
    Route::post('/rooms/edit/{id}', [AdminController::class, 'updateRoom'])->name('admin.room.update');
    Route::get('/rooms/delete/{id}', [AdminController::class, 'deleteRoom'])->name('admin.room.delete');
    Route::get('/bookings/confirm/{id}', [AdminController::class, 'confirmBooking'])->name('admin.booking.confirm');
    Route::get('/bookings/cancel/{id}', [AdminController::class, 'cancelBooking'])->name('admin.booking.cancel');
    Route::get('/bookings/delete/{id}', [AdminController::class, 'deleteBooking'])->name('admin.booking.delete');
    Route::get('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
});

require __DIR__.'/auth.php';